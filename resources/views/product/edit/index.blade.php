@extends('product.edit.layout')
@section('product_edit_header')
<div class="float-left" style="padding-top: 7px;">
    General
</div>
<div class="float-right">
    <a href="{{ route('store.product.show', ['product' => $product->slug]) }}" target="_blank" class="btn btn-secondary"> Preview Store</a>
</div>
@stop
@section('meadia_content')
    @include("product.edit.media.index")
@stop
@section('product_edit_content')


    @php
        $labelWidth = 3;
        $inputWidth = 8;
    @endphp

    <style>
        .select2-selection__choice__display {
            color: black;
            text-align: center;
            margin-left: 5px;
            padding: 5px 5px 3px 5px !important;
        }

        .select2-search__field {
            padding: 0px !important;
            border: 0px solid green !important;
            border-radius: 0px;
        }
    </style>


    
    <fieldset>
        <legend>
            <div style="text-align: center">Product Info</div>
        </legend>
        <div class="mb-3 row ">
            <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Product Name</label>
            <div class="col-sm-{{ $inputWidth }}">
                {!! Form::text('name', $product->name, ['class' => 'form-control ', 'id' => 'name']) !!}
            </div>
        </div>
        <div class="mb-3 row ">
            <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Category</label>
            <div class="col-sm-{{ $inputWidth }}">
                <select class="form-control" id="categories" name="categories[]" multiple="multiple">
                    @php
                        $categories = isset($product) ? $product->categories : [];
                    @endphp
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row ">
            <label for="brand" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Brand</label>
            <div class="col-sm-{{ $inputWidth }}">
                <select class="form-control" id="brand" name="brand">
                    <option value="">Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->uiud }}" {{$brand->id == $product->brand_id ? 'selected' : ''}}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row ">
            <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Description</label>
            <div class="col-sm-{{ $inputWidth }}">
                <textarea id="descriptionEditor" name="descriptionEditor" placeholder="Contest Description"></textarea>
            </div>
        </div>
    </fieldset>


    <fieldset>
        <legend>
            <div style="text-align: center">Price</div>
        </legend>
        <div class="form-group row mb-3">
            <label for="regular_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Regular
                Price:</label>
            <div class="col-sm-{{ $inputWidth }}">
                {!! Form::number('regular_price',  $product->regular_price, ['class' => 'form-control ', 'id' => 'name']) !!}
            </div>
        </div>
        <div class="form-group row  mb-3">
            <label for="sale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Sale Price: </label>
            <div class="col-sm-{{ $inputWidth }}">
                {!! Form::number('sale_price',  $product->sale_price , ['class' => 'form-control ', 'id' => 'name']) !!}
            </div>
        </div>
    </fieldset>


    <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
        <div class="col-sm-{{ $inputWidth }}">
            <button type="submit" class="btn btn-success">Update Product</button>
        </div>
    </div>


@stop

@push('scripts')

@php
    $ckEditorUrl = route('ckeditor.upload', ['_token' => csrf_token() ]);
@endphp
<script type="text/javascript">
    Product.edit.setEditor('{{ base64_encode($product->description) }}', '{{$ckEditorUrl}}');

    $('#categories').select2({
        placeholder: 'Select an Categories',
        allowClear: true,
        ajax: {
            url: "{{ route('categories.select2_data') }}",
            dataType: 'json',
            delay: 250,
            processResults: function(response) {
                return {
                    results: $.map(response, function(category) {
                        return {
                            text: category.name,
                            id: category.id,
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
    
@endpush
