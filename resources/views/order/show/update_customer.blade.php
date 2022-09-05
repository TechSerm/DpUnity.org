{{ Form::model($order, ['method' => 'PATCH', 'data-function' => 'updateProduct(form)' ,'route' => ['orders.customer.update', request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}

@php
$labelWidth = 4;
$inputWidth = 6;
@endphp

<div class="mb-3 row ">
    <label for="customer_name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Name</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('customer_name', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="customer_area" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Area</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('customer_area', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="customer_address" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Address</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('customer_address', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="customer_phone" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Phone</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('customer_phone', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</div>

{!! Form::close() !!}
