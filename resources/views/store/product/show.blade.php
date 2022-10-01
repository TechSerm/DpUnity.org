@extends('store.layout.layout')

@section('content')
    @livewire('shop-product', ['product' => $product, 'isShowPage' => true])
@stop