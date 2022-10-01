@extends('store.layout.layout')

@section('content')

    <div class="row">
        <div class="col-md-6">
            @include('store.order.summery')
        </div>

        <div class="col-md-6">
            @include("store.order.confirm")
        </div>
    </div>

@stop
