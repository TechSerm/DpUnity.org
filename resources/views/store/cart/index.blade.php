@extends('store.layout.layout')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="store-card mt-4">
                <div class="header" style="text-align: center; font-size: 18px;">
                    কাস্টমার ইনফরমেশন
                </div>
                <div class="body" style="font-size: 16px;">
                    @include("store.order.checkout.body")
                </div>
            </div>
        </div>
        <div class="col-md-7" style="">
            @include("store.order.summery")
        </div>
    </div>
@stop
