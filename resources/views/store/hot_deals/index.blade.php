@extends('store.layout.layout')
@section("title", "Hot Deals")
@section('content')
    <div class="home-listt" style="">
        <div class="home-list-headerr" style=" color: #000000; margin-top: 10px">
            <h4>Hot Deals</h4>
            <hr>
        </div>
        <div style="margin-right: -12px;">
            <div class="row no-gutters" style="" id="product-list">

                @include('store.product.single_product_page', ['products' => $hotDealProducts])
            </div>
        </div>
    </div>

@stop
