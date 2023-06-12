<?php

namespace App\Http\Controllers;

use App\Facades\Vendor\Vendor;
use App\Helpers\Constant;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\TemporaryProductRequest;
use App\Models\Product;
use App\Models\TemporaryProduct;
use App\Services\Image\ImageService;
use Illuminate\Http\Request;
use App\Services\Search\SearchService;
use Yajra\DataTables\Facades\DataTables;

class TemporaryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = TemporaryProduct::all();
        return view('temporary_product.index', [
            'products' => $products
        ]);
    }

    public function getData(Request $request)
    {
        $productQuery = TemporaryProduct::with(['imageTable', 'vendor']);

        if (auth()->user()->isVendor()) {
            $productQuery = $productQuery->where(['vendor_id' => auth()->user()->id]);
        }

        if (isset($request->search) && is_array($request->search) && $request->search['value'] != '') {
            $searchValue = strtolower($request->search['value']);
            $suggestionWords = SearchService::getSearchKeyword($searchValue);
            $productQuery->where(function ($query) use ($suggestionWords, $searchValue) {
                $query->orWhere('name', 'LIKE', "%{$searchValue}%");
                foreach ($suggestionWords as $word) {
                    $query->orWhereRaw('`name` LIKE ?', ['%' . trim(strtolower($word)) . '%']);
                }
            });
        }

        if (!request()->get('order')) {
            $productQuery = $productQuery->orderBy('updated_at', 'desc');
        }

        return Datatables::of($productQuery)
            ->filter(function ($query) use ($request) {
            })
            ->editColumn('name', function ($model) {
                return $model->name . " - <b>(" . bnConvert()->number($model->quantity) . " " . bnConvert()->unit($model->unit) . ")</b>";
            })
            ->editColumn('wholesale_price', function ($model) {
                return $this->addPriceLabel($model->wholesale_price);
            })
            ->editColumn('market_sale_price', function ($model) {
                return $this->addPriceLabel($model->market_sale_price);
            })

            ->editColumn('profit', function ($model) {
                return $this->addPriceLabel($model->profit);
            })
            ->editColumn('image', function ($model) {
                return "<img src='" . $model->image . "' height='50px' width='50px' class='img-fluid img-thumbnail'>";
            })
            ->editColumn('updated_at', function ($model) {
                return bnConvert()->date($model->updated_at->diffForHumans());
            })
            ->addColumn('vendor', function ($model) {
                return $model->vendor ? "<span class='badge' style='color: #ffffff; background-color:{$model->vendor->color}'>" . $model->vendor->name : '';
            })
            ->addColumn('action', function ($model) {
                $content = '';

                if (auth()->user()->isAdmin()) {
                    $content .= "<button data-url='" . route('temporary_products.confirm', ['temporary_product' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update Product <b>#" . $model->id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-check'></i></button>";
                }

                $content .= "<button data-url='" . route('temporary_products.edit', ['temporary_product' => $model->id]) . "' class='btn btn-primary btn-action btn-sm mr-1' data-modal-title='Confirm Product <b>#" . $model->id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";

                $content .= "<button data-url='" . route('temporary_products.destroy', ['temporary_product' => $model->id]) . "' class='btn btn-danger btn-action btn-sm' data-callback='reloadProductDatatable()' data-toggle='delete'><i class='fa fa-trash'></i></button>";

                return $content;
            })
            ->make(true);
    }

    private function addPriceLabel($price)
    {
        return '<span class="badge"><span style="font-size: 14px;">' . bnConvert()->number($price) . '</span><span style="color:#636e72;"> ৳ </span></span>';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = collect(Vendor::getList())->pluck('name', 'id')->toArray();

        return view('temporary_product.create', [
            'units' => Constant::UNITS,
            'vendors' => $vendors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemporaryProductRequest $request)
    {
        $imageId = null;

        if ($request->hasFile('image')) {
            $image = (new ImageService())->create('image');
            $imageId = $image ? $image->id : $imageId;
        }

        $product = TemporaryProduct::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'wholesale_price' => $request->wholesale_price,
            'market_sale_price' => $request->market_sale_price,
            'profit' => (int)$request->market_sale_price - $request->wholesale_price,

            'image_id' => $imageId,
            'vendor_id' => auth()->user()->isVendor() ? auth()->user()->id : $request->vendor_id,
        ]);

        return response()->json([
            'message' => 'Temporary Product Successfully Created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = TemporaryProduct::findOrFail($id);
        $vendors = collect(Vendor::getList())->pluck('name', 'id')->toArray();

        return view('temporary_product.edit', [
            'product' => $product,
            'units' => Constant::UNITS,
            'vendors' => $vendors
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TemporaryProductRequest $request, $id)
    {
        $product = TemporaryProduct::findOrFail($id);
        $imageId = $product->image_id;

        if ($request->hasFile('image')) {
            $image = $product->imageSrv()->createAndReplace('image');
            $imageId = $image ? $image->id : $imageId;
        }

        $product->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'wholesale_price' => $request->wholesale_price,
            'market_sale_price' => $request->market_sale_price,
            'profit' => (int)$request->market_sale_price - $request->wholesale_price,

            'image_id' => $imageId,
            'vendor_id' => auth()->user()->isVendor() ? auth()->user()->id : $request->vendor_id,
        ]);

        return response()->json([
            'message' => 'Product Successfully Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = TemporaryProduct::findOrFail($id);
        $product->imageSrv()->delete();
        $product->delete();
    }

    public function showConfirm($id)
    {
        $product = TemporaryProduct::findOrFail($id);
        $product->price = $product->market_sale_price;

        $vendors = collect(Vendor::getList())->pluck('name', 'id')->toArray();

        $productQuery = Product::with(['imageTable', 'vendor']);
        $searchValue = $product->name;
        $suggestionWords = SearchService::getSearchKeyword($searchValue);
        $productQuery->where(function ($query) use ($suggestionWords, $searchValue) {
            $query->orWhere('name', 'LIKE', "%{$searchValue}%");
            foreach ($suggestionWords as $word) {
                $query->orWhereRaw('`name` LIKE ?', ['%' . trim(strtolower($word)) . '%']);
            }
        });

        return view('temporary_product.confirm', [
            'product' => $product,
            'units' => Constant::UNITS,
            'vendors' => $vendors,
            'similarProducts' => $productQuery->get()
        ]);
    }

    public function confirm(ProductRequest $request, $id)
    {
        $this->authorize('products.create');
        $tempProduct = TemporaryProduct::findOrFail($id);
        $imageId = $tempProduct->image_id;

        $needDeleteImage = false;

        if ($request->hasFile('image')) {
            $image = (new ImageService())->create('image');
            $imageId = $image ? $image->id : $imageId;
            $needDeleteImage = true;
        }
        $product = Product::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'wholesale_price' => $request->wholesale_price,
            'market_sale_price' => $request->market_sale_price,
            'profit' => $request->profit,
            'price' => $request->price,
            'status' => $request->status,
            'delivery_fee' => $request->delivery_fee,
            'image_id' => $imageId,
            'vendor_id' => $request->vendor_id,
            'temp_categories_id' => json_encode($request->categories),
            'serial' => Product::all()->count() + 1
        ]);

        $product->categories()->sync($request->categories);
        $product->keyWordUpdate();

        if($needDeleteImage){
            $tempProduct->imageSrv()->delete();
        }
        $tempProduct->delete();
        

        return response()->json([
            'message' => 'Product Successfully Created',
            'product_id' => $product->id
        ]);;
    }
}
