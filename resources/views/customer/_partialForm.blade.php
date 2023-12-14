@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp



<div class="mb-3 row">
    <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Customer Mobile</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('customer_mobile', $mobile??null , ['class' => "form-control ", 'id' => 'customer_mobile']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Customer Name</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('customer_name', null , ['class' => "form-control ", 'id' => 'customer_name']) !!}
    </div>
</div>
<div class="mb-3 row">
    <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Customer Address</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::textarea('customer_address', null , ['class' => "form-control ", 'id' => 'customer_address']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{$labelWidth}} col-form-label form-control-label"></label>
    <div class="col-sm-{{$inputWidth}}">
        <button type="submit" class="btn btn-success">Create New Customer</button>
    </div>
</div>