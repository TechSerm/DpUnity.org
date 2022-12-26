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
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="orderDetails mb-3">
                <div class="header" style="background: #2980b9">
                    অর্ডার তথ্য
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
                    </table>

                    <div class="totalMessageArea">
                        অর্ডারটির কোনোকিছু পরিবর্তন করতে চাইলে আমাদের হটলাইনে যোগাযোগ করুন। আমাদের হটলাইন নাম্বার 
                        <a class="btn btn-success mt-1" href="tel:01777564786"><i class="fa fa-phone" aria-hidden="true"></i> 01777564786</a>
                    </div>
                </div>

            </div>

            <div class="orderDetails  mb-3">
                <div class="header" style="background: #DE8434">
                    অর্ডারকৃত পণ্য
                </div>
                <div class="body">
                    @include('store.order.show.items')
                </div>
            </div>

            <div class="orderDetails">
                <div class="header">
                    পণ্য ডেলিভারি তথ্য
                </div>
                <div class="body">
                    <table class="table table-bordered">
                        <tr>
                            <td class="infoTd">নাম </td>
                            <td>{{ $order->name }}</td>
                        </tr>
                        <tr>
                            <td>বাড়ির ঠিকানা</td>
                            <td>{{ $order->address }}</td>
                        </tr>
                        <tr>
                            <td>মোবাইল নাম্বার</td>
                            <td>{{ $order->phone }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
