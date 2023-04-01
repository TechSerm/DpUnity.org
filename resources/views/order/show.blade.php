@extends('layouts.app')
@section('content_header')
    <h1>Order #{{ $order->id }}</h1>
@endsection

@section('content')
    <style>
        .table>tbody>tr>td,
        th {
            vertical-align: middle;
            text-align: center
        }

        .orderDetails {
            padding: 2px;
            border: 1px solid #eeeeee;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;
            background: #ffffff;
        }

        .orderDetails .header {
            background-color: #8e44ad;
            color: #ffffff;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 5px 10px 5px;
            border-radius: 5px 5px 5px 5px;
        }

        .orderDetails .body {
            padding: 10px 5px 10px 5px;
        }

        .orderDetails table {
            font-size: 14px;
        }

        .orderDetails .infoTd {
            width: 120px;
        }

    </style>

    <div class="row">

        <div class="col-md-12">
            <div class="">
                
                <div class="pb-1">
                    <div class="row">
                        <div class="col-md-6">
                            @include('order.show.details', ['order', $order])
                        </div>
                        <div class="col-md-6">
                            @include('order.show.status_bar')
                        </div>
                    </div>
                </div>
            </div>
            <div class="cardd">
                <div class="card-bodyt">
                    @include('order.show.order_items', ['order', $order])
                </div>
            </div>
            @if (auth()->user()->isAdmin() || auth()->user()->isVendor())
            <div class="cardd">
                <div class="card-bodyy">
                    @include('order.show.vendors', ['order', $order])
                </div>
            </div>
            @endif
            {{-- <div class="cardd">
                <div class="card-bodyt">
                    @include('order.show.activity', ['order', $order])
                </div>
            </div> --}}
        </div>
    </div>
@endsection
