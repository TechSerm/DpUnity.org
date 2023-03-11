@php
    $labelWidth = 4;
    $inputWidth = 6;
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

@php
    $isVendor = auth()
        ->user()
        ->isVendor();
    $displayNone = $isVendor ? 'display: none' : '';
    
@endphp

<div class="mb-3 row ">
    <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পণ্যের নাম</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('name', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="quantity" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পরিমান</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('quantity', null, ['class' => 'form-control ', 'id' => 'quantity', 'step' => '0.01']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="unit" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">একক</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::select('unit', $units, null, [
            'placeholder' => 'Select Unit',
            'class' => 'form-control ',
            'id' => 'status',
        ]) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="wholesale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পাইকারি
        মূল্য</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('wholesale_price', null, ['class' => 'form-control ', 'id' => 'wholesale_price']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="market_sale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">বাজার দর</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('market_sale_price', null, ['class' => 'form-control ', 'id' => 'market_sale_price']) !!}
    </div>
</div>

@if (auth()->user()->isAdmin())
<div class="mb-3 row">
    <label for="vendor_id" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Vendor</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::select('vendor_id', $vendors, null, [
            'placeholder' => 'Select Vendor',
            'class' => 'form-control ',
            'id' => 'vendor_id',
        ]) !!}
    </div>
</div>
@endif

<div class="mb-3 row">
    <label for="image1" class="col-sm-{{ $labelWidth }} col-form-label form-control-label" for="image">পণ্যের
        ছবি</label>
    <div class="col-sm-{{ $inputWidth }}">
        <div style="">
            <input type="file" name="image" id="image" onchange="previewFile(event)">
        </div>
        <img src="{{ isset($product) ? $product->image : url('images/default.png') }}" id="image-preview"
            height="180px" width="180px" class="img-thumbnail mt-2" alt="">
    </div>
</div>


<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">Save Product</button>
    </div>
</div>
