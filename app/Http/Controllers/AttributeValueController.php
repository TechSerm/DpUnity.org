<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attribute\AttributeRequest;
use App\Http\Requests\Attribute\AttributeValueRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeValueController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeValueRequest $request)
    {
        $attribute = Attribute::where(['uuid' => $request->attribute])->firstOrFail();

        AttributeValue::create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'attribute_id' => $attribute->id
        ]); 

        return response()->json([
            'message' => 'Successfully created value'
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
    public function edit(AttributeValue $attributeValue)
    {
        return view('attributes.edit_value', compact('attributeValue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, AttributeValue $attributeValue)
    {
        $attributeValue->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Successfully updated attribute value.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return response()->json([
            'message' => 'Successfully deleted attribute value'
        ]);
    }
}
