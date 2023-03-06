@extends('layouts.app')
@section('content_header')
    <h1>Active Orders</h1>
@endsection

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
                    সবগুলো চলমান অর্ডার এর তালিকা
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
                            @if (auth()->user()->isAdmin())
                                
                            
                            <tr>
                                <td class="infoTd" style="width: 150px;">কাস্টমারের নাম </td>
                                <td style="">{{ $order->name }}</td>
                            </tr>
                            <tr>
                                <td class="infoTd" style="width: 150px;">কাস্টমারের ঠিকানা </td>
                                <td style="">
                                    @if (strlen($order->address) >= 150)
                                        {!! substr($order->address, 0, 150). "..." !!}
                                    @else
                                        {{ $order->address }}
                                    @endif
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td>অর্ডারটি করা হয়েছে</td>
                                <td>{{ bnConvert()->date($order->created_at->format('d M Y, H:i')) }}
                                    ({{ bnConvert()->date($order->created_at->diffForHumans()) }})</td>
                            </tr>
                            <tr>
                                <td>অর্ডারটির বর্তমান অবস্থা</td>
                                <td><span class="badge" style="background: {{$order->customer_status['color'] ?? 'red'}}; color: #000000">{{$order->customer_status['name'] ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td>সর্বমোট:</td>
                                <td>৳ {{ bnConvert()->number(auth()->user()->isAdmin() ? $order->total: $order->vendor_wholesale_total) }}</td>
                            </tr>
                        </table>
    
                        <div class="totalMessageArea">
                            <a class="btn btn-info mt-0" href="{{ route('orders.show', ['order' => $order->id]) }}"><i class="fa fa-eye" aria-hidden="true"></i> সম্পূর্ণ অর্ডারটি দেখুন</a>
                        </div>
                    </div>
    
                </div>
            </div>
        @endforeach
    </div>

@endsection
