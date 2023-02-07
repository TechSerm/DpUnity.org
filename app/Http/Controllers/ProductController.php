<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\WooQueue;
use App\Services\File\FileService;
use App\Services\Image\ImageService;
use Illuminate\Http\Request;
use App\Services\Product\ProductService;
use App\Services\Search\SearchService;
use App\Services\WooCommerce\WooCommerceService;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $this->authorize('products.index');
        $products = Product::all();
        return view('product.index', [
            'products' => $products
        ]);
    }

    public function getData(Request $request)
    {
        $this->authorize('products.index');
        $productQuery = Product::with(['imageTable']);

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
            ->editColumn('profit', function ($model) {
                return $this->addPriceLabel($model->profit);
            })
            ->editColumn('wholesale_price', function ($model) {
                return $this->addPriceLabel($model->wholesale_price);
            })
            ->editColumn('market_sale_price', function ($model) {
                return $this->addPriceLabel($model->market_sale_price);
            })
            ->editColumn('delivery_fee', function ($model) {
                return $this->addPriceLabel($model->delivery_fee == '' ? 19 : $model->delivery_fee);
            })
            ->editColumn('price', function ($model) {
                return $this->addPriceLabel($model->price);
            })
            ->editColumn('image', function ($model) {
                return "<img src='" . $model->image . "' height='50px' width='50px' class='img-fluid img-thumbnail'>";
            })
            ->editColumn('updated_at', function ($model) {
                return bnConvert()->date($model->updated_at->diffForHumans());
            })
            ->editColumn('status', function ($model) {
                $statusColor = $model->status == 'private' ? 'danger' : 'success';
                return "<span class = 'badge badge-{$statusColor}'>" . $model->status . "</span>";
            })
            ->addColumn('categories', function ($model) {
                $categories = $model->categories;
                $content = "";
                foreach ($categories as $category) {
                    $content .= "<span class='badge badge-secondary'>" . $category->name . "</span>";
                }

                return $content;
            })
            ->addColumn('action', function ($model) {
                $content = '';
                if (request()->user()->can('products.edit')) {
                    $content = "<button data-url='" . route('products.edit', ['product' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update Product <b>#" . $model->id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";
                }
                if (request()->user()->can('products.history')) {
                    $content .= "<button data-url='" . route('products.history', ['product' => $model->id]) . "' class='btn btn-primary btn-action btn-sm mr-1' data-modal-title='Update Product <b>#" . $model->id . "</b>'
                data-modal-size='1200' data-toggle='modal'><i class='fa fa-history'></i></button>";
                }
                if (request()->user()->can('products.delete')) {
                    $content .= "<button data-url='" . route('products.destroy', ['product' => $model->id]) . "' class='btn btn-danger btn-action btn-sm' data-callback='reloadProductDatatable()' data-toggle='delete'><i class='fa fa-trash'></i></button>";
                }
                return $content;
            })
            ->make(true);
    }

    private function addPriceLabel($price)
    {
        return '<span class="badge"><span style="font-size: 14px;">' . bnConvert()->number($price) . '</span><span style="color:#636e72;"> ৳ </span></span>';
    }

    public function create()
    {
        $this->authorize('products.create');
        return view('product.create', [
            'units' => Constant::UNITS
        ]);
    }

    public function store(ProductRequest $request)
    {
        $this->authorize('products.create');
        $imageId = null;

        if ($request->hasFile('image')) {
            $image = (new ImageService())->create('image');
            $imageId = $image ? $image->id : $imageId;
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
            'temp_categories_id' => json_encode($request->categories)
        ]);

        $product->categories()->sync($request->categories);
        $product->keyWordUpdate();

        return back()->with('success', 'Product create successfully!');
    }


    public function show($id)
    {
        $this->authorize('products.show');
        $product = Product::findOrFail($id);
        return view('product.show', ['product' => $product]);
    }

    public function edit($id)
    {
        $this->authorize('products.edit');
        $product = Product::findOrFail($id);
        return view('product.edit', [
            'product' => $product,
            'units' => Constant::UNITS
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $this->authorize('products.edit');
        $product = Product::findOrFail($id);
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
            'profit' => $request->profit,
            'price' => $request->price,
            'status' => $request->status,
            'delivery_fee' => $request->delivery_fee,
            'image_id' => $imageId,
            'temp_categories_id' => json_encode($request->categories)
        ]);

        $product->categories()->sync($request->categories);
        $product->keyWordUpdate();

        return response()->json([
            'message' => 'Product Successfully Updated'
        ]);
    }

    public function history($id)
    {
        $this->authorize('products.history');
        $product = Product::findOrFail($id);
        return view('product.history', ['activities' => $product->activities()->orderBy('id', 'desc')->get()]);
    }

    public function destroy($id)
    {
        $this->authorize('products.delete');
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function productPrice()
    {
        $products = Product::paginate(20)->onEachSide(1);
        return view('product_price.index', [
            'products' => $products
        ]);
    }

    public function productPriceUpdate(Request $request)
    {
       // dd($request->all());
        $products = Product::whereIn('id', $request->product_id)->get();

        foreach ($products as $key => $product) {
            $wholeSalePrice = $request->wholesale_price[$key] ?? 0;
            $marketSalePrice = $request->market_sale_price[$key] ?? 0;
            $profit = $marketSalePrice - $wholeSalePrice;

            $isPriceUpdate = !(($wholeSalePrice < 0 || $marketSalePrice < 0) || ($product->wholesale_price == $wholeSalePrice && $product->market_sale_price == $marketSalePrice));

            $updatedData = [];

            if($isPriceUpdate){
                $updatedData = [
                    'wholesale_price' => $wholeSalePrice,
                    'market_sale_price' => $marketSalePrice,
                    'profit' => $profit,
                    'price' => $marketSalePrice,
                ];
            }

            if($product->status == 'publish' && !isset($request->productStatus[$product->id])){
                $updatedData['status'] = 'private';
            }

            if($product->status == 'private' && isset($request->productStatus[$product->id])){
                $updatedData['status'] = 'publish';
            }
            
            if(!empty($updatedData)){
                $updatedData['wholesale_price_last_update'] = Carbon::now();
                $product->update($updatedData);
            }
            
        }

        return response()->json([
            'message' => 'Successfully Price Update'
        ]);
    }
}
