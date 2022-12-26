{{ Form::model($order, ['method' => 'PUT', 'data-function' => 'updateCustomerInfo(form)' ,'route' => ['orders.customer.update', request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}

@php
$labelWidth = 4;
$inputWidth = 6;
@endphp

<div class="mb-3 row ">
    <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">নাম</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('name', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="address" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">বাড়ির ঠিকানা</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::textarea('address', null, ['class' => 'form-control ', 'id' => 'address']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="phone" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">মোবাইল নাম্বার</label>
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
