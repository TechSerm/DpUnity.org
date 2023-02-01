@extends('store.layout.layout')
@section('content')

    <style>
        .loader-area {
            display: none;
            text-align: center;
        }

        .orderArea a {
            text-decoration: none;
        }

        .orderAreaCard {
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 5px;
            width: 100%;
            color: #000000;
            box-shadow: 0 2px 4px 0 #0d87a9, 0 3px 10px 0 #f8bbd0;
        }

        .orderArea .pending {
            background: #ffeaa7;
        }

        .orderArea .canceled {
            background: #fab1a0;
        }

        .orderArea .progressing {
            background: #a0b9e9;
        }

        .orderArea .complete {
            background: #7bed9f;
        }

        .orderAreaCard:hover {
            box-shadow: 0 2px 4px 0 #b11771, 0 3px 10px 0 #f8bbd0;
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

        .hotline-card {
            color: #000000;
            padding: 5px;
            box-shadow: 0 2px 4px 0 #aaaaaa, 0 3px 10px 0 #aaaaaa;
        }

        a:hover {
            outline: 0px;
        }
    </style>

    <div style="">
        <img class=""
            src="{{ asset('assets/img/welcome_banner.jpg') }}"
            style="width: 100%;border-radius: 5px" alt="">
        <div class="row mt-3">
            @if (!deviceInfo()->hasDeviceToken() || (deviceInfo()->hasDeviceToken() && deviceInfo()->getAppVersion() != config("bibisena.android_app_version")))
            
            <div class="col-md-4 col-sm-4 col-12">
                <div class="card hotline-card mb-3" style="text-align: center; font-size: 20px; height: 130px">
                    <div style="height: 80px">
                        বিবিসিনা অ্যান্ড্রয়েড অ্যাপ<br />
                        @php
                            $needUpdate = false;
                        @endphp
                        @if ((deviceInfo()->hasDeviceToken() && deviceInfo()->getAppVersion() != config("bibisena.android_app_version")))
                            @php
                                $needUpdate = true;
                            @endphp
                            <div style="color: red; font-size: 14px">আপনি এপটির পুরাতন ভার্সন ব্যবহার করছেন।  সর্বোচ্চ পারফরমেন্স পেতে এপটির নতুন ভার্সন আপডেট করুন। </div>
                        @endif
                    </div>
                    
                    <a class="btn btn-info mt-1" href="https://play.google.com/store/apps/details?id=com.amirhamza.bibisena"><i class="fa fa-download" aria-hidden="true"></i> {{$needUpdate ? "নতুন ভার্সন আপডেট" : "ডাউনলোড"}} করুন </a>
                </div>
                </a>
            </div>
            @endif
            <div class="col-md-4 col-sm-4 col-12">

                <div class="card hotline-card" style="text-align: center; font-size: 20px;">
                    <div style="height: 80px">
                        যেকোনো প্রয়োজনে যোগাযোগ করুন আমাদের হটলাইন নাম্বারে
                    </div>
                    <a class="btn btn-success mt-1" href="tel:01603169395"><i class="fa fa-phone" aria-hidden="true"></i>
                        01603169395</a>
                </div>

            </div>
        </div>
    </div>
    <div class="row orderArea mt-3">
        @foreach ($activeOrders as $order)
            <div class="col-md-4">
                <a href="{{ route('store.order.show', ['uuid' => $order->uuid]) }}">
                    <div class="orderAreaCard" style="background: {{$order->customer_status['color']}}">
                        {{bnConvert()->date($order->created_at->diffForHumans())}}, আপনি একটি অর্ডার করেছেন। {{$order->customer_status['name']}}।<br />
                        অর্ডার নম্বর: {{ bnConvert()->number($order->id, false) }}<br />
                        সর্বমোট: ৳ {{ bnConvert()->number($order->total) }}<br />
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="row no-gutters" style="margin: 15px -15px 0px -5px;" id="product-list">

        @include('store.product.single_product_page')
    </div>
    <div class="loader-area" id="loader-area">
        <img src="{{ asset('assets/img/loader.gif') }}" height="70px" width="70px" alt="">
    </div>

@stop

@push('scripts')
    <script>
        Store.home.init({
            url: "{{ route('store.home.products') }}"
        });
    </script>
@endpush
