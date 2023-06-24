<!DOCTYPE html>
<html>

<head>
    <title>Order - {{ $order->id }}</title>
    <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">

    <style>
        body {
            font-family: 'SolaimanLipi', Arial, sans-serif;
        }

        .invoice {}

        .invoice-header {
            text-align: left;
            margin-bottom: 20px;
        }

        .invoice-header img {
            height: 70px;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .invoice-details {
            margin-bottom: 20px;
            font-size: 16px;
            float: left;
        }

        .invoice-details p {
            margin: 0;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 7px 5px 7px 5px;
            font-size: 14px;
            text-align: center
        }

        tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
            /* Set the background color for odd rows */
        }

        .invoice-table th {
            background-color: #5C5E5D;
            color: #ffffff;
            border: 1px solid #ffffff;
            text-align: center;
            font-weight: bold;
        }

        .invoice-table tbody td {
            border: 1px solid #dadada;
        }

        .invoice-total {
            text-align: right;
        }

        tfoot td {
            text-align: right;
        }

        tfoot td {
            padding: 10px 0px 10px 0px;
            font-size: 16px;
        }

        .total-td {
            text-align: right !important;
        }

        @media print {
            @page {
                size: A4;
            }
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="invoice-header">
            <img src="{{ asset('assets/img/bibisena_logo.png') }}" alt="">
        </div>

        <div class="invoice-details" style="font-size: 16px;">
            <p style="font-size: 20px; font-weight: bold">{{ $order->name }}</p>
            <p>{{ $order->address }}</p>
            <p>মোবাইল: {{ $order->phone }}</p>
        </div>

        <div class="invoice-details" style="float: right;">
            <div style="font-size: 30px;">অর্ডার নাম্বার: {{ bnConvert()->number($order->id) }}</div>
            <div style="font-size: 14px;">
                অর্ডারটি করা হয়েছে: {{ bnConvert()->date($order->created_at->format('d M Y, h:i a')) }}
            </div>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 15px;">ক্রমিক</th>
                    <th>পণ্যের বিবরন</th>
                    <th style="width: 55px;">পরিমান</th>
                    <th style="width: 70px;">দর</th>
                    <th style="width: 80px;">টাকা</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $items = $order->items;
                @endphp
                @foreach ($items as $key => $item)
                    <tr>
                        <td> {{ bnConvert()->number($key + 1) }} </td>
                        <td style="text-align: left">{{ $item->name }} -
                            {{ bnConvert()->floatNumber($item->unit_quantity, false) }}
                            {{ bnConvert()->unit($item->unit) }} </td>
                        <td>{{ bnConvert()->floatNumber($item->quantity) }}</td>
                        <td>৳ {{ bnConvert()->number($item->price) }}</td>
                        <td>৳ {{ bnConvert()->number($item->total) }}</td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="total-td">পণ্যের মূল্য:</td>
                    <td colspan="1">{{ bnConvert()->number($order->subtotal) }} টাকা</td>
                </tr>
                <tr>
                    <td colspan="4" class="total-td">ডেলিভারি ফি:</td>
                    <td colspan="1">{{ bnConvert()->number($order->delivery_fee) }} টাকা</td>
                </tr>
                <tr style="font-weight: bold;">
                    <td colspan="4" class="total-td">সর্বমোট মূল্য:</td>
                    <td colspan="1">{{ bnConvert()->number($order->total) }} টাকা</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div
        style="text-align: center; margin-top: 15px; font-size: 14px; border-top: 1px solid #eeeeee;padding: 15px 10px 0px 10px;color: #555555">
        বিবিসেনায় অর্ডার করার জন্য আপনাকে ধন্যবাদ । অর্ডারটি নিয়ে আপনার কোনো অভিযোগ থাকলে আপনি আমাদের হটলাইন নাম্বারে
        যোগাযোগ করুণ। আমাদের হটলাইন নাম্বার {{ env('STORE_MOBILE_NUMBER') }}। আপনার পণ্যগুলো যদি খারাপ, মেয়াদ শেষ,
        ওজণে কম অথবা কোনো পণ্য যদি অনুপস্থিত থাকে আমাদের জানান। আমরা আপনার পণ্য গুলো আবার পরিবর্তন করে দিব।
    </div>
</body>
</html>