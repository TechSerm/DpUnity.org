<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\File\FileService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.index', [
            'categories' => $categories
        ]);
    }

    public function getData(Request $request)
    {
        $productQuery = Category::where([]);

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
            ->addColumn('action', function ($model) {

                $content = "<button data-url='" . route('categories.edit', ['category' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update Product <b>#" . $model->woo_id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";
                $content .= "<button data-url='" . route('categories.history', ['category' => $model->id]) . "' class='btn btn-primary btn-action btn-sm mr-1' data-modal-title='Update Product <b>#" . $model->woo_id . "</b>'
                data-modal-size='1200' data-toggle='modal'><i class='fa fa-history'></i></button>";
                $content .= "<button data-url='" . route('categories.destroy', ['category' => $model->id]) . "' class='btn btn-danger btn-action btn-sm' data-callback='reloadProductDatatable()' data-toggle='delete'><i class='fa fa-trash'></i></button>";

                return $content;
            })
            ->make(true);
    }

    public function getSelect2Data(Request $request)
    {

        $categories = Category::where(function ($query) {
            if (isset(request()->q)) {
                $query->where('name', 'like', '%' . request()->q . '%');
            }
        })->get();

        $problems = $categories->map(function ($problem) {
            return $problem->only(['id', 'name']);
        });

        return $problems;
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'image' => $this->getImageUrl($request, null)
        ]);

        return back()->with('success', 'Product create successfully!');
    }

    public function show($id)
    {
        return view('order.index');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', ['category' => $category]);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'image' => $this->getImageUrl($request, $category->image)
        ]);

        $category->woo()->update();

        return response()->json([
            'message' => 'Category Successfully Updated'
        ]);
    }

    public function getImageUrl(CategoryRequest $request, $defaultImage)
    {
        return $request->hasFile('image') ? (new FileService())->imageStore('image') : $defaultImage;
    }

    public function history($id)
    {
        $category = Category::findOrFail($id);
        return view('product.history', ['activities' => $category->activities()->orderBy('id', 'desc')->get()]);
    }

    public function sync($id)
    {
        $category = Category::findOrFail($id);
        $category->woo()->sync();

        return back()->with('success', 'Category Sync successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}