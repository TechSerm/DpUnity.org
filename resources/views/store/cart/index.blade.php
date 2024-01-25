@extends('store.layout.layout')

@section('content')
    <div class="row">
        <div class="col-md-6">

        </div>
        <div class="col-md-6" style="">
            @livewire('cart.cart-items')
        </div>
    </div>
@stop
