<?php

namespace App\Http\Controllers;

use App\Facades\Vendor\Vendor;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\Image\ImageService;
use Illuminate\Http\Request;
use App\Services\Product\ProductService;
use App\Services\Search\SearchService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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
            $productQuery = $productQuery->orderBy('id', 'desc');
        }

        return Datatables::of($productQuery)
            ->filter(function ($query) use ($request) {
            })
            ->editColumn('image', function ($model) {
                return "<img src='" . $model->image . "' height='50px' width='50px' class='img-fluid img-thumbnail'>";
            })
            ->editColumn('has_hot_deals', function ($model) {
                $checked = $model->has_hot_deals ? "checked" : "";
                $url = route('product.edit.update_hot_deals', $model);

                return "
                    <label class='switch'>
                    <input type='checkbox' data-url='$url' data-type='hot_deals' onchange='Product.updateToggle(this)' $checked>
                    <span class='slider round'></span>
                    </label>
                ";
            })
            ->editColumn('status', function ($model) {
                $checked = $model->status == "publish" ? "checked" : "";
                $url = route('product.edit.update_status', $model);
                return "
                    <label class='switch'>
                    <input type='checkbox' data-url='$url' data-type='status' onchange='Product.updateToggle(this)' $checked>
                    <span class='slider round'></span>
                    </label>
                ";
            })
            ->addColumn('action', function ($model) {
                $content = '';
                $content .= "<a target='_blank' href='" . route('store.product.show', ['product' => $model->slug]) . "' class='btn btn-info btn-action btn-sm mr-1' title='View Store'><i class='fa fa-eye'></i></a>";
                $content .= "<a href='" . route('products.edit', ['product' => $model->id]) . "' class='btn btn-primary btn-action btn-sm mr-1''><i class='fa fa-edit'></i></a>";
                $content .= "<button data-url='" . route('products.destroy', ['product' => $model->id]) . "' class='btn btn-danger btn-action btn-sm' data-callback='reloadProductDatatable()' data-toggle='delete'><i class='fa fa-trash'></i></button>";
                
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
            'slug' => $this->createSlug($request->name)
        ]);

        $product->categories()->sync($request->categories);

        return response()->json([
            'message' => 'Product Successfully Created',
            'url' => route('products.edit', $product)
        ]);
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
        $brands = Brand::all();
        return view('product.edit', compact('product', 'brands'));
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

        $brand = Brand::where(['uuid' => $request->brand_id])->first();

        $product->update([
            'name' => $request->name,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'description' => $request->description,
            'image_id' => $imageId,
            'brand_id' => $brand ? $brand->id : null,
            'slug' => $this->createSlug($request->name, $product->id)
        ]);

        $product->categories()->sync($request->categories);

        return response()->json([
            'message' => 'Product Successfully Updated'
        ]);
    }

    public function createSlug($productName, $productId = null)
    {
        $slug = Str::slug($productName);

        if ($slug == "") $slug = "product_";

        $productQuery = Product::where([]);
        if ($productId != null) $productQuery = Product::where('id', '!=', $productId);

        $count = $productQuery->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        while (1) {
            $tmpSlug = $count ? "{$slug}-{$count}" : $slug;
            if ($productQuery->where('slug', '=', $tmpSlug)->exists()) {
                $count++;
                continue;
            }

            break;
        }
        // if other slugs exist that are the same, append the count to the slug
        $slug = $count ? "{$slug}-{$count}" : $slug;

        return $slug;
    }

    public function updateHotDeals(Product $product, Request $request)
    {
        $isEnable = $request->hot_deals_enable == "true";
        $product->update([
            'has_hot_deals' =>  $isEnable ? true : false
        ]);


        return response()->json([
            'message' => 'Successfully ' . ($isEnable ? 'enable' : 'disable') . ' hot deals'
        ]);
    }

    public function updateStatus(Product $product, Request $request)
    {
        $product->update([
            'status' => $request->status_enable == "true" ? "publish" : "private"
        ]);

        return response()->json([
            'message' => 'Successfully updated status'
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
