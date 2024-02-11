<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Services\Image\ImageService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('brand.index', [
            'brands' => $brands
        ]);
    }

    public function getData(Request $request)
    {
        $productQuery = Brand::where([]);

        if (!request()->get('order')) {
            $productQuery = $productQuery->orderBy('updated_at', 'desc');
        }

        return DataTables::of($productQuery)
            ->filter(function ($query) use ($request) {
            })
            ->editColumn('updated_at', function ($model) {
                return $model->updated_at->diffForHumans();
            })
            ->editColumn('image', function ($model) {
                return "<img src='" . $model->image . "' height='50px' width='50px' class='img-fluid img-thumbnail'>";
            })
            ->addColumn('action', function ($model) {
                $content = "<button data-url='" . route('brands.edit', ['brand' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update Brand <b>#" . $model->id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";
                $content .= "<button data-url='" . route('brands.history', ['brand' => $model->id]) . "' class='btn btn-primary btn-action btn-sm mr-1' data-modal-title='Update Brand <b>#" . $model->id . "</b>'
                data-modal-size='1200' data-toggle='modal'><i class='fa fa-history'></i></button>";
                $content .= "<button data-url='" . route('brands.destroy', ['brand' => $model->id]) . "' class='btn btn-danger btn-action btn-sm' data-callback='reloadProductDatatable()' data-toggle='delete'><i class='fa fa-trash'></i></button>";
                return $content;
            })
            ->make(true);
    }

    public function create()
    {
        // $this->authorize('brand.create');
        return view('brand.create');
    }

    public function store(BrandRequest $request)
    {
        // $this->authorize('brands.create');
        $imageId = null;

        if ($request->hasFile('image')) {
            $image = $this->getImageService((new ImageService()))->create('image');
            $imageId = $image ? $image->id : $imageId;
        }

        $brand = Brand::create([
            'name' => $request->name,
            'image_id' => $imageId
        ]);

        return back()->with('success', 'Brand created successfully!');
    }

    public function show($id)
    {
        abort(404);
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('brand.edit', ['brand' => $brand]);
    }

    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $imageId = $brand->image_id;

        if ($request->hasFile('image')) {
            $imgSrv = $this->getImageService($brand->imageSrv());
            $image = $imgSrv->createAndReplace('image');
            $imageId = $image ? $image->id : $imageId;
        }

        $brand->update([
            'name' => $request->name,
            'image_id' => $imageId
        ]);

        return response()->json([
            'message' => 'Brand Successfully Updated'
        ]);
    }

    private function getImageService($imgSrv)
    {
        return $imgSrv->setText("");
    }

    public function history($id)
    {
        $brand = Brand::findOrFail($id);
        return view('product.history', ['activities' => $brand->activities()->orderBy('id', 'desc')->get()]);
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->imageSrv()->delete();
        $brand->delete();
    }
}
