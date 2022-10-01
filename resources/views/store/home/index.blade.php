@extends('store.layout.layout')
@section('content')

    <style>
        .loader-area {
            display: none;
            text-align: center;
        }

        .orderArea {
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 5px;
            width: 100%;
            background: #f8bbd0;
            color: #000000;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);
        }

        .searchArea {
            position: fixed;
            z-index: 1500;
            background: #ffffff;
            width: 100%;
            margin: -15px 0px -0px -15px;
            text-align: center
        }

        .searchArea input {
            padding: 5px;
            width: 80%;
        }
    </style>
    @foreach ($activeOrders as $order)
        <a href="{{ route('store.order.show', ['uuid' => $order->uuid]) }}">
            <div class="orderArea">
                2 minute age আপনি একটি অর্ডার করেছেন।<br />
                অর্ডার নম্বর: {{ bnConvert()->number($order->id, false) }}<br />
                সর্বমোট: ৳ {{ bnConvert()->number($order->total) }}<br />
            </div>
        </a>
    @endforeach

    <div class="orderArea" style="background: #9980FA">
        আপনার সবগুলো অর্ডার দেখুন
    </div>

    <div class="row no-gutters" style="margin: 15px -15px 0px -5px;" id="product-list">

        @include('store.product.single_product_page')
    </div>
    <div class="loader-area" id="loader-area">
        <img src="{{asset('assets/img/loader.gif')}}" height="70px" width="70px"
            alt="">
    </div>

@stop

@push('scripts')
    <script>
        Store.home.init({
            url: "{{ route('store.home.products') }}"
        });
    </script>
@endpush
