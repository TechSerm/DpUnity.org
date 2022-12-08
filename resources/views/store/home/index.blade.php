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
    {{-- <div class="row orderArea">
        @foreach ($activeOrders as $order)
            <div class="col-md-6">
                <a href="{{ route('store.order.show', ['uuid' => $order->uuid]) }}">
                    <div class="orderAreaCard pending">
                        ২ মিনিট আগে আপনি একটি অর্ডার করেছেন। আপনার অর্ডারটির প্রস্তুতি চলছে।<br />
                        অর্ডার নম্বর: {{ bnConvert()->number($order->id, false) }}<br />
                        সর্বমোট: ৳ {{ bnConvert()->number($order->total) }}<br />
                    </div>
                </a>
            </div>
        @endforeach
    </div> --}}


    <div style="">
        <img class=""
            src="https://tajabajar.s3.ap-south-1.amazonaws.com/uploads/all/esjU7Qqs5Uq2ehUvzMPJZlGaNnG4pKKR1mexvyBm.jpg"
            style="width: 100%;border-radius: 5px" alt="">
        <div class="row mt-2">
            <div class="col-md-4 col-sm-4 col-12">
                <a href="https://play.google.com/store/apps/details?id=com.amirhamza.bibisena">
                    <div class="card hotline-card" style="text-align: center;">
                        ডাউনলোড করুন বিবিসিনা অ্যান্ড্রয়েড অ্যাপ<br />
                        <center>
                            <img src="https://i1.wp.com/9to5google.com/wp-content/uploads/sites/4/2022/07/current-google-play-icon.jpg?ssl=1"
                                height="50px" width="50px" alt="">
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-4 col-12 mt-2">
                <a href="tel:8665562570">
                    <div class="card hotline-card" style="text-align: center">
                        <div style=""></div> যেকোনো প্রয়োজনে যোগাযোগ করুন<br />
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        01777564786
                    </div>
                </a>
            </div>
        </div>
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
