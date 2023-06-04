@php
    //item = product
    //item = orderItem *->product

@endphp

@if ($item && !isset($item->order_id))
<div class="mb-3 row ">
    <label for="product_id" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পণ্যের আইডি</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('product_id', $item->product ? $item->product_id : $item->id, ['class' => 'form-control ', 'id' => 'name', 'readonly'=> 'true']) !!}
    </div>
</div>
@endif

<div class="mb-3 row ">
    <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পণ্যের নাম</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('name', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="unit_quantity" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">এককের পরিমান</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('unit_quantity', $item ? (($item->product) ? $item->unit_quantity : $item->quantity) : "", ['class' => 'form-control ', 'step' => '0.01']) !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="unit" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পণ্যের একক</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::select('unit', $units, null, [
            'placeholder' => 'Select Unit',
            'class' => 'form-control ',
            'id' => 'status',
        ]) !!}
    </div>
</div>

@if ($order->is_vendor_assign)
<div class="mb-3 row">
    <label for="vendor_id" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">বিক্রেতা</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::select('vendor_id', collect($vendors)->pluck('name', 'id')->toArray(), $item ? $item->vendor_id: '', [
            'placeholder' => 'Select Unit',
            'class' => 'form-control ',
            'id' => 'vendor_id',
        ]) !!}
    </div>
</div>
@endif
@if ($item)
@php
    $productImage = asset('images/default.png');
    if($item->product)$productImage = $item->product->image;
    else if($item->image)$productImage = $item->image;
@endphp

<div class="mb-3 row ">
    <label for="image" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পণ্যের ছবি</label>
    <div class="col-sm-{{ $inputWidth }}">
        <img src="{{ $productImage }}" 
        height="180px" width="180px" class="img-thumbnail mt-2" alt="">
    </div>
</div>
@endif

<div class="mb-3 row ">
    <label for="delivery_fee" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">ডেলিভারি ফী</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('delivery_fee', $item ? (is_null($item->delivery_fee) ? config('bibisena.default_delivery_fee') : $item->delivery_fee ) : config('bibisena.default_delivery_fee'), ['class' => 'form-control ']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="quantity" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">কেনার পরিমান</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('quantity', rtrim(rtrim(number_format($item->order_id ? $item->quantity : 1, 2, '.', ','), '0'), '.'), ['class' => 'form-control ', 'id' => 'quantity', 'onkeyup' => 'updateOrderItemPrice()']) !!}
    </div>
</div>



<div class="mb-3 row ">
    <label for="price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">বিবিসিনা মূল্য</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('price', null, ['class' => 'form-control ', 'id' => 'price', 'onkeyup' => 'updateOrderItemPrice()']) !!}
    </div>
</div>



<div class="mb-3 row ">
    <label for="wholesale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পাইকারি মূল্য</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('wholesale_price', null, ['class' => 'form-control ', 'id' => 'wholesale_price', 'onkeyup' => 'updateOrderItemPrice()']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="total" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">সর্বমোট মূল্য </label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('total', $item->order_id ? $item->total :  $item->price, ['class' => 'form-control ', 'id' => 'total', 'readonly' => true]) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="wholesale_price_total" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">সর্বমোট পাইকারি মূল্য</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('wholesale_price_total', $item->order_id ? $item->wholesale_price_total : $item->wholesale_price, ['class' => 'form-control ', 'id' => 'wholesale_price_total', 'readonly' => true]) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="profit" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">লাভ</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('profit', null, ['class' => 'form-control ', 'id' => 'profit', 'readonly' => true]) !!}
    </div>
</div>