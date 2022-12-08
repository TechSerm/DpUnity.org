@extends('store.layout.layout')

@section('content')

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            @include('store.order.summery')
        </div>
        <div class="col-md-6">
            @include('store.order.checkout.modal')
        </div>
    </div>
@stop
