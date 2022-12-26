<div class="mb-3 row ">
    <label for="product_id" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পণ্যের আইডি</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('product_id', $item->product ? $item->product_id : $item->id, ['class' => 'form-control ', 'id' => 'name', 'readonly'=> 'true']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পণ্যের নাম</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('name', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="unit_quantity" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">এককের পরিমান</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('unit_quantity', $item->product ? $item->unit_quantity : $item->quantity, ['class' => 'form-control ', 'step' => '0.01']) !!}
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


<div class="mb-3 row ">
    <label for="image" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পণ্যের ছবি</label>
    <div class="col-sm-{{ $inputWidth }}">
        <img src="{{$item->product->image ?? $item->image}}" 
        height="180px" width="180px" class="img-thumbnail mt-2" alt="">
    </div>
</div>

<div class="mb-3 row ">
    <label for="delivery_fee" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">ডেলিভারি ফী</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('delivery_fee', is_null($item->delivery_fee) ? config('bibisena.default_delivery_fee') : $item->delivery_fee, ['class' => 'form-control ']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="quantity" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">কেনার পরিমান</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('quantity', $item->product ? $item->quantity : 0, ['class' => 'form-control ', 'id' => 'quantity', 'onkeyup' => 'updateOrderItemPrice()']) !!}
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
        {!! Form::text('total', $item->product ? $item->total :  0, ['class' => 'form-control ', 'id' => 'total', 'readonly' => true]) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="wholesale_price_total" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">সর্বমোট পাইকারি মূল্য</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('wholesale_price_total', $item->product ? $item->wholesale_price_total : 0, ['class' => 'form-control ', 'id' => 'wholesale_price_total', 'readonly' => true]) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="profit" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">লাভ</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('profit', $item->product ? $item->profit :  0, ['class' => 'form-control ', 'id' => 'profit', 'readonly' => true]) !!}
    </div>
</div>