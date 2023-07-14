
@extends('store.layout.layout')

@section('content')
    <div class="row">
        @include('store.product.single_product_page', ['products' => $products])
    </div>
@stop
