<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\File\FileService;
use App\Services\Image\ImageService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize('categories.index');
        $categories = Category::all();
        return view('category.index', [
            'categories' => $categories
        ]);
    }

    public function getData(Request $request)
    {
        $this->authorize('categories.index');
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
            ->addColumn('status', function ($model) {
                return "
                <label class='switch'>
                <input type='checkbox' checked>
                <span class='slider round'></span>
                </label>
                ";
            })
            ->addColumn('action', function ($model) {
                if (request()->user()->can('categories.edit')) {
                    $content = "<button data-url='" . route('categories.edit', ['category' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update Category <b>#" . $model->id . "</b>'
                    data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";
                }
                if (request()->user()->can('categories.delete')) {
                    $content .= "<button data-url='" . route('categories.destroy', ['category' => $model->id]) . "' class='btn btn-danger btn-action btn-sm' data-callback='reloadProductDatatable()' data-toggle='delete'><i class='fa fa-trash'></i></button>";
                }
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
        $this->authorize('categories.create');
        return view('category.create');
    }

    public function store(CategoryRequest $request)
    {
        $this->authorize('categories.create');
        $imageId = null;

        if ($request->hasFile('image')) {
            $image = $this->getImageService((new ImageService()))->create('image');
            $imageId = $image ? $image->id : $imageId;
        }

        $category = Category::create([
            'name' => $request->name,
            'image_id' => $imageId
        ]);

        return back()->with('success', 'Category create successfully!');
    }

    public function show($id)
    {
        $this->authorize('categories.show');
        return view('order.index');
    }

    public function edit($id)
    {
        $this->authorize('categories.edit');
        $category = Category::findOrFail($id);
        return view('category.edit', ['category' => $category]);
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->authorize('categories.edit');
        $category = Category::findOrFail($id);
        $imageId = $category->image_id;

        if ($request->hasFile('image')) {
            $imgSrv = $this->getImageService($category->imageSrv());
            $image = $imgSrv->createAndReplace('image');
            $imageId = $image ? $image->id : $imageId;
        }

        $category->update([
            'name' => $request->name,
            'image_id' => $imageId
        ]);

        return response()->json([
            'message' => 'Category Successfully Updated'
        ]);
    }

    private function getImageService($imgSrv)
    {
        return $imgSrv->setHeight(600)->setWidth(600)->setText("");
    }


    public function history($id)
    {
        $this->authorize('categories.history');
        $category = Category::findOrFail($id);
        return view('product.history', ['activities' => $category->activities()->orderBy('id', 'desc')->get()]);
    }

    public function destroy($id)
    {
        $this->authorize('categories.delete');
        $category = Category::findOrFail($id);
        $category->imageSrv()->delete();
        $category->delete();
    }
}
