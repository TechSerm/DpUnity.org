<?php

namespace App\Http\Controllers;

use App\Facades\Vendor\Vendor;
use App\Helpers\Constant;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
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
        $productQuery = Product::with(['imageTable']);

        if (isset($request->category)) {
            $category = Category::findOrFail($request->category);
            $cProducts = $category->products()->pluck('id')->toArray();
            $productQuery->whereIn('id', $cProducts);
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
            ->editColumn('image', function ($model) {
                return "<img src='" . $model->image . "' height='50px' width='50px' class='img-fluid img-thumbnail'>";
            })
            ->editColumn('has_hot_deals', function ($model) {
                $checked = $model->has_hot_deals ? "checked" : "";
                return "
                    <label class='switch'>
                    <input type='checkbox' $checked>
                    <span class='slider round'></span>
                    </label>
                ";
            })
            ->editColumn('status', function ($model) {
                $checked = $model->status == "publish" ? "checked" : "";
                return "
                    <label class='switch'>
                    <input type='checkbox' $checked>
                    <span class='slider round'></span>
                    </label>
                ";
            })
            ->addColumn('action', function ($model) {
                $content = '';
                if (request()->user()->can('products.edit')) {
                    $content = "<a href='" . route('products.edit', ['product' => $model->id]) . "' class='btn btn-primary btn-action btn-sm mr-1''><i class='fa fa-edit'></i></a>";
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

        return view('product.create');
    }

    public function stockAndPrice($productId)
    {
        $product = Product::with(['attributes', 'attributes.values', 'attributes.values.value'])->findOrFail($productId);
        return view('product.edit.stock_and_price', ['product' => $product]);
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
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'status' => $request->status ? 'publish' : 'private',
            'has_hot_deals' => $request->has_hot_deals ? true : false,
            'image_id' => $imageId,
        ]);

        $product->categories()->sync($request->categories);

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
}
