{{ Form::model($order, ['method' => 'PUT', 'data-function' => 'updateCustomerInfo(form)' ,'route' => ['orders.vendor.update', request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}

@php
$labelWidth = 4;
$inputWidth = 6;
@endphp

<div class="mb-3 row">
    <label for="vendor_id" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">বিক্রেতা</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::select('vendor_id', $vendors, $order->vendor_id, [
            'placeholder' => 'Select Vendor',
            'class' => 'form-control ',
            'id' => 'status',
        ]) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</div>

{!! Form::close() !!}
