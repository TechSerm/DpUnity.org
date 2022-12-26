{{ Form::model($item, ['method' => 'PATCH', 'data-function' => 'updateOrderItem(form)' ,'route' => ['order_items.update', request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}

@php
$labelWidth = 4;
$inputWidth = 6;
@endphp



    <div class="row">
        <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
        <div class="col-sm-{{ $inputWidth }}">
            {!!request()->already_exists ? '<div class="alert alert-warning">পণ্যটি ইতিমধ্যে যুক্ত করা হয়েছে।</div>' : ''!!}
        </div>
    </div>
    

@include('order.show.order_item._partialForm')

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</div>

{!! Form::close() !!}
