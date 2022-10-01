@extends('store.layout.layout')

@section('content')
    @livewire('cart.cart-items')
    @include('store.order.confirm')
@stop
