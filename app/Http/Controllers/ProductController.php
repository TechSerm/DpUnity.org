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
use App\Services\WooCommerce\WooCommerceService;
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
        $products = Product::all();
        return view('product.index', [
            'products' => $products
        ]);
    }

    public function getData(Request $request)
    {
        $productQuery = Product::where([]);

        if (!request()->get('order')) {
            $productQuery = $productQuery->orderBy('updated_at', 'desc');
        }

        return Datatables::of($productQuery)
            ->filter(function ($query) use ($request) {
            })
            ->editColumn('image', function ($model) {
                return "<img src='" . $model->image . "' height='50px' width='50px' class='img-fluid img-thumbnail'>";
            })
            ->editColumn('updated_at', function ($model) {
                return $model->updated_at->diffForHumans();
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

                $content = "<button data-url='" . route('products.edit', ['product' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update Product <b>#" . $model->woo_id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";
                $content .= "<button data-url='" . route('products.history', ['product' => $model->id]) . "' class='btn btn-primary btn-action btn-sm mr-1' data-modal-title='Update Product <b>#" . $model->woo_id . "</b>'
                data-modal-size='1200' data-toggle='modal'><i class='fa fa-history'></i></button>";
                $content .= "<button data-url='" . route('products.destroy', ['product' => $model->id]) . "' class='btn btn-danger btn-action btn-sm' data-callback='reloadProductDatatable()' data-toggle='delete'><i class='fa fa-trash'></i></button>";

                return $content;
            })
            ->make(true);
    }

    public function create()
    {
        return view('product.create', [
            'units' => Constant::UNITS
        ]);
    }

    public function store(ProductRequest $request)
    {
        $imageId = null;

        if ($request->hasFile('image')) {
            $image = (New ImageService())->create('image');
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
            'image_id' => $imageId,
            'temp_categories_id' => json_encode($request->categories)
        ]);
        
        $product->categories()->sync($request->categories);
        
        return back()->with('success', 'Product create successfully!');
    }


    public function show($id)
    {
        return view('order.index');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('product.edit', [
            'product' => $product,
            'units' => Constant::UNITS
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
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
        $product = Product::findOrFail($id);
        return view('product.history', ['activities' => $product->activities()->orderBy('id', 'desc')->get()]);
    }

    public function sync($id)
    {
        $product = Product::findOrFail($id);
        return back()->with('success', 'Product Sync successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
