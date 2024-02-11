@php
    //item = product
    //item = orderItem *->product

@endphp

@if ($item && !isset($item->order_id))
<div class="mb-3 row ">
    <label for="product_id" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Product Code</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('product_id', $item->product ? $item->product_id : $item->id, ['class' => 'form-control ', 'id' => 'name', 'readonly'=> 'true']) !!}
    </div>
</div>
@endif

<div class="mb-3 row ">
    <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Product Name</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('name', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>


@if ($item)
@php
    $productImage = asset('images/default.png');
    if($item->product)$productImage = $item->product->image;
    else if($item->image)$productImage = $item->image;
@endphp

<div class="mb-3 row ">
    <label for="image" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Product Image</label>
    <div class="col-sm-{{ $inputWidth }}">
        <img src="{{ $productImage }}" 
        height="180px" width="180px" class="img-thumbnail mt-2" alt="">
    </div>
</div>
@endif

<div class="mb-3 row ">
    <label for="quantity" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Quantity</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('quantity', rtrim(rtrim(number_format($item->order_id ? $item->quantity : 1, 2, '.', ','), '0'), '.'), ['class' => 'form-control ', 'id' => 'quantity', 'onkeyup' => 'updateOrderItemPrice()']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Price</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('price', null, ['class' => 'form-control ', 'id' => 'price', 'onkeyup' => 'updateOrderItemPrice()']) !!}
    </div>
</div>


<div class="mb-3 row ">
    <label for="total" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Total </label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('total', $item->order_id ? $item->total :  $item->price, ['class' => 'form-control ', 'id' => 'total', 'readonly' => true]) !!}
    </div>
</div>
