@extends('store.layout.layout')

@section('content')

    <div class="row">
        <div class="col-md-6">
            @livewire('order.order-details')
        </div>
        <div class="col-md-6">
            @livewire('cart.cart-items')
        </div>
    </div>

@stop
