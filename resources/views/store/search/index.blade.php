@extends('store.layout.layout')
@section('title', "Search Product")
@section('content')
    <div class="row no-gutters" style="margin: 15px -15px 0px -5px;" id="searchResultProductList">
        @include('store.product.single_product_page', ['products' => $products])
    </div>
    <div style="float: right">{{ $products->appends(['q' => request()->q])->links() }}</div>
    <div class="loader-area" id="search-loader-area" style="display: none">
        <img src="{{ asset('assets/img/loader.gif') }}" height="70px" width="70px" alt="">
    </div>
@stop
