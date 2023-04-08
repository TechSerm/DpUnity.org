<?php

namespace App\Http\Controllers;

use App\Facades\Vendor\Vendor;
use App\Helpers\Constant;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
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
            'products' => $products,
            'vendors' => Vendor::getList(),
            'categories' => Category::all(),
        ]);
    }

    public function offer()
    {
        return view('product.offer');
    }

    public function getData(Request $request)
    {
        $this->authorize('products.index');
        $productQuery = Product::with(['imageTable', 'vendor']);

        if (isset($request->category)) {
            $category = Category::findOrFail($request->category);
            $cProducts = $category->products()->pluck('id')->toArray();
            $productQuery->whereIn('id' , $cProducts);
        }

        if (auth()->user()->isVendor()) {
            $productQuery = $productQuery->where(['vendor_id' => auth()->user()->id]);
        }

        if (isset($request->product_id) && $request->product_id) {
            $productQuery->where(['id' => $request->product_id]);
        }

        if (isset($request->has_stock)) {
            $productQuery->where(['has_stock' => $request->has_stock == 'yes' ? true : false]);
        }

        if (isset($request->status)) {
            $productQuery->where(['status' => $request->status]);
        }

        if (isset($request->vendor)) {
            $productQuery->where(['vendor_id' => $request->vendor]);
        }

        if (isset($request->product_name) && $request->product_name != '') {
            $searchValue = strtolower($request->product_name);
            $suggestionWords = SearchService::getSearchKeyword($searchValue);
            $productQuery->where(function ($query) use ($suggestionWords, $searchValue) {
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
                return $this->addPriceLabel($model->delivery_fee == '' ? config('bibisena.default_delivery_fee') : $model->delivery_fee);
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
            ->editColumn('vendor_id', function ($model) {
                return $model->vendor ? "<span class='badge' style='color: #ffffff;background-color: {$model->vendor->color}'>" . $model->vendor->name . '</span>' : '';
            })
            ->editColumn('has_stock', function ($model) {
                $statusColor = $model->has_stock ? 'primary' : 'warning';
                return "<span class = 'badge badge-{$statusColor}'>" . ($model->has_stock ? '<i class="fa fa-check"></i> আছে' : '<i class="fa fa-times"></i> নেই') . "</span>";
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
        $vendors = collect(Vendor::getList())->pluck('name', 'id')->toArray();

        return view('product.create', [
            'units' => Constant::UNITS,
            'vendors' => $vendors
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
            'vendor_id' => $request->vendor_id,
            'temp_categories_id' => json_encode($request->categories)
        ]);

        $product->categories()->sync($request->categories);
        $product->keyWordUpdate();

        return response()->json([
            'message' => 'Product Successfully Created'
        ]);;
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
        $vendors = collect(Vendor::getList())->pluck('name', 'id')->toArray();

        return view('product.edit', [
            'product' => $product,
            'units' => Constant::UNITS,
            'vendors' => $vendors
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
            'vendor_id' => $request->vendor_id,
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
        $product->imageSrv()->delete();
        $product->delete();
    }

    public function getSuggestionsProductName(Request $request)
    {
        $suggestionWords = SearchService::getSearchKeyword($request->input('query'));

        return response()->json($suggestionWords);
    }

    public function productPrice(Request $request)
    {
        $categories = Category::all();

        $category = Category::where(['id' => request()->category])->first();
        if ($category) {
            $productQuery = $category->products()->with(['imageTable']);
        } else {
            $productQuery = Product::with(['imageTable']);
        }

        if (auth()->user()->isVendor()) {
            $productQuery->where(['vendor_id' => auth()->user()->id]);
        }

        if (isset($request->product_name)) {
            $searchValue = strtolower($request->product_name);
            $suggestionWords = SearchService::getSearchKeyword($searchValue);
            $productQuery->where(function ($query) use ($suggestionWords, $searchValue) {
                $query->orWhere('name', 'LIKE', "%{$searchValue}%");
                foreach ($suggestionWords as $word) {
                    $query->orWhereRaw('`name` LIKE ?', ['%' . trim(strtolower($word)) . '%']);
                }
            });
        }

        $products = $productQuery->paginate(20);

        return view('product_price.index', [
            'products' => $products,
            'categories' => $categories
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

            if ($isPriceUpdate) {
                $updatedData = [
                    'wholesale_price' => $wholeSalePrice,
                    'market_sale_price' => $marketSalePrice,
                    'profit' => $profit,
                    'price' => $marketSalePrice,
                ];
            }

            if ($product->has_stock && !isset($request->productHasStock[$product->id])) {
                $updatedData['has_stock'] = false;
            }

            if (!$product->has_stock && isset($request->productHasStock[$product->id])) {
                $updatedData['has_stock'] = true;
            }

            if (!empty($updatedData)) {
                $updatedData['wholesale_price_last_update'] = Carbon::now();
                $product->update($updatedData);
            }
        }

        return response()->json([
            'message' => 'Successfully Price Update'
        ]);
    }
}
