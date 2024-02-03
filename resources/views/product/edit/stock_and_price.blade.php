@extends('product.edit.layout')
@section('product_edit_header')
Stock and Price
@stop
@section('product_edit_content')
    @php
        $labelWidth = 3;
        $inputWidth = 7;
    @endphp

    <fieldset>
        <legend>
            <div style="text-align: center">Attribute List</div>
        </legend>
        <div class="row">
            <div class="col-md-12">
                <div class="float-right">
                    <button class="btn btn-primary" data-toggle="modal" data-modal-size="500" data-modal-title="Add Attribute" data-url="{{route('product_attributes.create', $product)}}">Add Attribute</button>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <table class="table table-bordered" style="background: white">
                <tr>
                    <th style="width: 20%">Name</th>
                    <th>Values</th>
                    <th style="width: 15%"></th>
                </tr>
                @php
                    $attributes = $product->attributes;
                @endphp
                @foreach ($attributes as $attribute)
                    <tr>
                        <td>{{$attribute->name}}</td>
                        <td>
                            @php
                                $attributeValues = $attribute->values;
                            @endphp
                            @foreach ($attributeValues as $attributeValue)
                                <span class="badge badge-secondary">{{$attributeValue->name}}</span>
                            @endforeach
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-modal-title="Edit Attributes" data-url="{{route('product_attributes.edit', array_merge(request()->route()->parameters(), ['product_attribute' => $attribute->uuid]))}}" >
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-toggle="delete" data-url="{{route('product_attributes.destroy', array_merge(request()->route()->parameters(), ['product_attribute' => $attribute->uuid]))}}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </fieldset>

    <fieldset>
        <legend>
            <div style="text-align: center">Varients</div>
        </legend>
        <div class="mt-2" style="background: white">
            <table class="table table-bordered">
                <tr>
                    <th>Variant</th>
                    <th>Regular Price</th>
                    <th>Sale Price</th>
                    <th>Stock Quantity</th>
                </tr>
                <tr>
                    <td>XL-Test</td>
                    <td>
                        <input type="text" class="form-control">
                    </td>
                    <td>
                        <input type="text" class="form-control">
                    </td>
                    <td>
                        <input type="text" class="form-control">
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>

@stop
