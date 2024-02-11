@extends('store.layout.layout')
@section('title', "Cart")
@section('content')
    <style>
        .continueShippingLinkColor{
            color: var(--theme-color);
            font-weight: bold;
        }
    </style>
    @if (empty($items))
        <div class="store-card">
            <div class="body" style="text-align: center; height: 400px; padding-top: 180px; font-size: 18px">
                No Item in in cart. <a class="continueShippingLinkColor" href="{{ route('home') }}">Continue Shopping</a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-5">
                <div class="store-card mt-4">
                    <div class="header" style="text-align: center; font-size: 18px;">
                        কাস্টমার ইনফরমেশন
                    </div>
                    <div class="body" style="font-size: 16px;">
                        @include('store.order.checkout.body')
                    </div>
                </div>
            </div>
            <div class="col-md-7" style="">
                @include('store.order.summery')
            </div>
        </div>
    @endif
@stop
