@extends('store.layout.layout')
@section('title', theme()->title() . ' - ' . theme()->slogan())
@section('content')

    <div class="store-card">
        <div class="body" style="padding: 0px;">
            <img class="img-thumbnail"
                src="{{ asset('assets/img/banner_dp_1.jpg') }}"
                alt="">
        </div>
    </div>
    <div class="store-card">
        <div class="body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('assets/img/logo_dp.jpg') }}" height="320px;"
                        width="340px" alt="">
                </div>
                <div class="col-md-8 d-flex align-items-center" style="font-size: 20px;font-weight: bold">
                    প্রিয় দৌলতপুর এলাকাবাসী, আমরা দৌলতপুর গ্রামের প্রবাসীরা মিলে গঠন করেছি "দৌলতপুর প্রবাসী ফাউন্ডেশন"।
                    আমরা এলাকার গরিব, অসহায়, দুস্ত মানুষের পাশাপাশি সামাজিক কাজে নিয়জিত থাকব। এটি একটি অরাজনৈতিক, অলাভজনক
                    দাতব্য ফাউন্ডেশন।
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="store-card">
                
                <div class="body">
                    <img class="img-thumbnail" src="{{ asset('assets/img/uae_inauguration.jpeg') }}" style="width: 100%" alt="">
                </div>
                <div class="header text-center" style="margin-top: -10px">
                    সংযুক্ত আরব আমিরাতের বানিয়াছ সিটিতে উদ্বোধনী  অনুষ্ঠান
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="store-card">
                
                <div class="body">
                    <img class="img-thumbnail" src="{{ asset('assets/img/france_inauguration.jpeg') }}" style="width: 100%" alt="">
                </div>
                <div class="header text-center" style="margin-top: -10px">
                    ফ্রান্সের প্যারিসে উদ্বোধনী অনুষ্ঠান
                </div>
            </div>
        </div>
    </div>
    
    <div class="store-card">
        <div class="body text-center">
            <h4>ওয়েবসাইট এর কাজ চলমান </h4>
        </div>
    </div>


@stop

