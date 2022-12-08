@extends('store.layout.layout')

@section('content')

    <a href="/categories" class="link"><i class="fa fa-list-alt" aria-hidden="true"></i> ক্যাটেগরি</a> / {{$category->name}}
    <hr>
    <div class="row no-gutters" style="margin: 15px -15px 0px -5px;" id="product-list">
        @include('store.product.single_product_page')
    </div>

@stop
