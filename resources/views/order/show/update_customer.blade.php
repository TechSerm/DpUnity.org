{{ Form::model($order, ['method' => 'PUT', 'data-function' => 'updateCustomerInfo(form)', 'route' => ['orders.customer.update', request()->route()->parameters()], 'files' => true, 'class' => 'form-horizontal']) }}

@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp

<fieldset>
    <legend>
        <div style="text-align: center">Shipping Info</div>
    </legend>
    <div class="mb-3 row mt-2">
        <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Shipping Name</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::text('name', null, ['class' => 'form-control ', 'id' => 'name']) !!}
        </div>
    </div>

    <div class="mb-3 row ">
        <label for="address" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Shipping
            Address</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::textarea('address', null, ['class' => 'form-control ', 'id' => 'address']) !!}
        </div>
    </div>

    <div class="mb-3 row ">
        <label for="phone" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Shipping
            Mobile</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::text('phone', null, ['class' => 'form-control ', 'id' => 'phone']) !!}
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>
        <div style="text-align: center">Status</div>
    </legend>
    <div class="mb-3 row ">
        <label for="status" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Order Staus</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::select('status', $orderStatus , null, ['class' => 'form-control ', 'id' => 'status', 'disabled' => $order->isOrderStatusDisabled() ? true: false]) !!}
        </div>
    </div>

    <div class="mb-3 row mt-2">
        <label for="payment_status" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Payment Staus</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::select('payment_status', $orderPaymentStatus , null, ['class' => 'form-control ', 'id' => 'payment_status']) !!}
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>
        <div style="text-align: center">Delivery Fee</div>
    </legend>
    <div class="mb-3 row mt-2">
        <label for="phone" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Delivary Fee</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::number('delivery_fee', null, ['class' => 'form-control ', 'id' => 'phone']) !!}
        </div>
    </div>

</fieldset>
<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</div>

{!! Form::close() !!}
