@extends('layouts.app')
@section('content_header')
    <h1>Order #{{ $order->woo_id }}</h1>
@endsection

@section('content')
    <style>
        .table>tbody>tr>td,
        th {
            vertical-align: middle;
            text-align: center
        }
    </style>

    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-5">
                    @include('order.show.status_bar')
                </div>
            </div>
            <div class="card">
                <div class="card-body pb-5">
                    @include('order.show.details', ['order', $order])
                </div>
            </div>
            <div class="card">
                <div class="card-body pb-5">
                    @include('order.show.order_items', ['order', $order])
                </div>
            </div>
        </div>
    </div>
@endsection
