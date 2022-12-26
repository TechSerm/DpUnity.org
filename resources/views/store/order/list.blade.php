@extends('store.layout.layout')
@section('content')
<style>
    .orderDetails {
        padding: 2px;
        border: 1px solid #eeeeee;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 5px;
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

    <div class="row orderArea mt-3">
        <div class="col-md-12">
            <div class="orderDetails mb-3">
                <div class="header" style="background: #2980b9">
                    আপনার করা সবগুলো অর্ডার এর তালিকা
                </div>
            </div>
        </div>
         
        @foreach ($orders as $order)
        
            <div class="col-md-4">
                <div class="orderDetails mb-3">
                    <div class="header" style="background: #2980b9">
                        অর্ডার #{{ $order->id }}
                    </div>
                    <div class="body">
                        <table class="table table-bordered">
                            <tr>
                                <td class="infoTd" style="width: 150px;">অর্ডার নাম্বার </td>
                                <td style="font-weight: bold; font-size: 16px;">{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <td>অর্ডারটি করা হয়েছে</td>
                                <td>{{ bnConvert()->date($order->created_at->format('d M Y, H:i')) }}
                                    ({{ bnConvert()->date($order->created_at->diffForHumans()) }})</td>
                            </tr>
                            <tr>
                                <td>অর্ডারটির বর্তমান অবস্থা</td>
                                <td><span class="badge" style="background: {{$order->customer_status['color']}}; color: #000000">{{$order->customer_status['name'] }}</span></td>
                            </tr>
                            <tr>
                                <td>সর্বমোট:</td>
                                <td>৳ {{ bnConvert()->number($order->total) }}</td>
                            </tr>
                        </table>
    
                        <div class="totalMessageArea">
                            <a class="btn btn-info mt-0" href="{{ route('store.order.show', ['uuid' => $order->uuid]) }}"><i class="fa fa-eye" aria-hidden="true"></i> সম্পূর্ণ অর্ডারটি দেখুন</a>
                        </div>
                    </div>
    
                </div>
            </div>
        @endforeach
    </div>
@stop
