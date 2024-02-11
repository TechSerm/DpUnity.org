<?php

namespace App\Http\Controllers;

use App\Http\Requests\Slider\SliderRequest;
use App\Http\Requests\Slider\SliderUpdateRequest;
use App\Models\Slider;
use Illuminate\Support\Str;
use App\Services\Image\ImageService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('slider.index', [
            'sliders' => Slider::serialOrder()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        $imageId = null;

        if ($request->hasFile('image')) {
            $image = (new ImageService())->create('image');
            $imageId = $image ? $image->id : $imageId;
        }

        $category = Slider::create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'image_id' => $imageId,
            'serial' => Slider::max('serial') + 1
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
    public function edit(Slider $slider)
    {
        return view('slider.edit', [
            'slider' => $slider
        ]);
    }

    public function updateOrder(Slider $slider)
    {
        $order = request()->order;
        $sliders = Slider::whereIn('uuid', $order)->get();

        foreach ($sliders as $key => $slider) {
            $orderSerial = array_search($slider->uuid, $order) + 1;
            $slider->update([
                'serial' => $orderSerial,
            ]);
        }

        return response()->json([
            "message" => "Successfully updated position"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderUpdateRequest $request, Slider $slider)
    {
        $imageId = $slider->image_id;

        if ($request->hasFile('image')) {
            $imgSrv = $this->getImageService($slider->imageSrv());
            $image = $imgSrv->createAndReplace('image');
            $imageId = $image ? $image->id : $imageId;
        }

        $slider->update([
            'title' => $request->title,
            'image_id' => $imageId
        ]);

        return response()->json([
            'message' => 'Slider Successfully Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->imageSrv()->delete();
        $slider->delete();
    }
}
