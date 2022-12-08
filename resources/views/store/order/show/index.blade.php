@extends('store.layout.layout')

@section('content')

    <div class="row">
        <div class="col-md-6">
            Order #{{$order->id}}
            {{$order->customer_name}}
        </div>
        <div class="col-md-6">
            
        </div>
    </div>

@stop
