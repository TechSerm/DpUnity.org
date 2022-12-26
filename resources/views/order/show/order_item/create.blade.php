{{ Form::model($item, ['method' => 'POST', 'data-function' => 'updateOrderItem(form)' ,'route' => ['order_items.store', request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}

@php
$labelWidth = 4;
$inputWidth = 6;
@endphp


@include('order.show.order_item._partialForm')

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">Add Items</button>
    </div>
</div>

{!! Form::close() !!}

