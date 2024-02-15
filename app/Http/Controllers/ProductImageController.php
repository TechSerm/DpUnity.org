<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductImageStoreRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\Image\ImageService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.edit.media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product, ProductImageStoreRequest $request)
    {
        $imageId = null;

        if ($request->hasFile('image')) {
            $image = (new ImageService())->create('image');
            $imageId = $image ? $image->id : $imageId;
        }
        
        if($imageId == null) {
            return response()->json([
                'message' => "Unable to add new image"
            ]);
        }

        $productImage = ProductImage::Create([
            'uuid' => Str::uuid(),
            'product_id' => $product->id,
            'image_id' => $imageId
        ]);

        return response()->json([
            'message' => "Successfully added product gallery",
            'url' => $image->src(),
            'uuid' => $productImage->uuid,
            'remove_url' => route('product_images.destroy', array_merge(request()->route()->parameters(), ['product_image' => $productImage->uuid]))
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,  $productImage)
    {
        $productImage = $product->images()->where(['uuid' => $productImage])->firstOrFail();
        $productImage->imageSrv()->delete();
        $productImage->delete();

        return response()->json([
            'message' => 'Image Successfully Removed'
        ]);
    }
}
