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
        <div class="col-md-5">
            <div class="store-card mt-3" >
                <div class="header" style="text-align: center; font-size: 18px;">
                    অর্ডার তথ্য
                </div>
                <div class="body">
                    <table class="table table-bordered mb-1">
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
                            <td><span class="badge"
                                    style="background: {{ $order->customer_status['color'] }}; color: #000000">{{ $order->customer_status['name'] }}</span>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <td class="infoTd" style="width: 150px;">ক্রেতার নাম </td>
                            <td style="">{{ $order->name }}</td>
                        </tr>
                        <tr>
                            <td>ক্রেতার ঠিকানা</td>
                            <td>{{ $order->address }}</td>
                        </tr>
                        <tr>
                            <td>ক্রেতার মোবাইল</td>
                            <td>{{ $order->phone }}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
        <div class="col-md-7">


            <div class="store-card  mt-3">
                <div class="header" style="text-align: center; font-size: 18px;">
                    অর্ডারকৃত পণ্য
                </div>
                <div class="body">
                    @include('store.order.show.items')
                </div>
            </div>

            <div class="store-card  mt-1">
                <div class="body">
                    <table class="orderTotalTable">
                        <tr class="orderSummeryTableTotalTr">
                            <td class="tdTitle" colspan="2"><span>Subtotal:</span></td>
                            <td>৳ <b>{{ bnConvert()->number($order->subtotal) }}</b></td>
                        </tr>
                        <tr class="orderSummeryTableTotalTr">
                            <td class="tdTitle" colspan="2"><span>Payment Method:</span></td>
                            <td> <b>Cash On Delivery</b></td>
                        </tr>
                        <tr class="orderSummeryTableTotalTr">
                            <td class="tdTitle" colspan="2">Shipping Charge:</td>
                            <td>৳ <b>{{ bnConvert()->number($order->delivery_fee) }}</b></td>
                        </tr>
            
                        <tr class="orderSummeryTableTotalTr">
                            <td class="tdTitle" colspan="2"><span class="badge" style="font-size: 14px">Grand Total:</span></td>
                            <td>৳ <b>{{ bnConvert()->number($order->total) }}</b></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

@stop
