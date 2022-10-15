{{ Form::model($order, ['method' => 'PATCH', 'data-function' => 'updateProduct(form)' ,'route' => ['orders.customer.update', request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}

@php
$labelWidth = 4;
$inputWidth = 6;
@endphp

<div class="mb-3 row ">
    <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Name</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('name', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="address" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Address</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('address', null, ['class' => 'form-control ', 'id' => 'address']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="phone" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Phone</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('phone', null, ['class' => 'form-control ', 'id' => 'phone']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</div>

{!! Form::close() !!}
