@extends('store.layout.layout')
@section('title', theme()->title() . ' - ' . theme()->slogan())
@section('content')

    <style>
        .db-social .jumbotron {
            margin: 0;
            background: url({{$member->cover_photo}});
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: bottom center;
            color: #fff !important;
            height: 300px;
            position: relative;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, .3);
            padding: 0;
        }

        .db-social .head-profile {
            margin-top: -120px;
            border-radius: 4px;
            position: relative;
        }

        .widget {
            background: #fff;
            border-radius: 0;
            border: none;
            margin-bottom: 30px;
        }

        .has-shadow {
            box-shadow: 0 1px 15px 1px rgba(52, 40, 104, .08);
        }

        .db-social .widget-body {
            padding: 1rem 1.4rem;
        }

        .widget-body {
            padding: 1.4rem;
        }

        .pb-0,
        .py-0 {
            padding-bottom: 0 !important;
        }

        .db-social .image-default img {
            width: 120px;
            position: absolute;
            top: -80px;
            left: 0;
            right: 0;
            margin: 0 auto;
            box-shadow: 0 0 0 6px rgba(255, 255, 255, 1);
            z-index: 10;
        }

        .db-social .infos {
            text-align: center;
            margin-top: 4rem;
            margin-bottom: 1rem;
            line-height: 1.8rem;
        }

        .db-social h2 {
            color: #2c304d;
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: .2rem;
        }

        .db-social .location {
            color: #aea9c3;
            font-size: 1rem;
        }

        .db-social .follow .btn {
            padding: 10px 30px;
        }

        .btn:not(:disabled):not(.disabled) {
            cursor: pointer;
        }

        .btn-shadow,
        .btn-shadow a {
            color: #5d5386;
            background-color: #fff;
            border-color: #fff;
            box-shadow: 0 1px 15px 1px rgba(52, 40, 104, .15);
        }

        .db-social .head-profile .actions {
            display: inline-block;
            vertical-align: middle;
            margin-left: .5rem;
        }



        .db-social .head-profile li:first-child {
            padding-left: 0;
        }

        .db-social .head-profile li {
            display: inline-block;
            text-align: center;
            padding: 0 1rem;
        }

        .db-social .head-profile li .counter {
            color: #2c304d;
            font-size: 1.4rem;
            font-weight: 600;
        }

        .db-social .head-profile li .heading {
            color: #aea9c3;
            font-size: 1rem;
        }
        .td1 {
            width: 100px;
            background: #f5f5f5;
        }
    </style>
    <div class="container db-social">
        <div class="jumbotron jumbotron-fluid"></div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-11">
                    <div class="widget head-profile has-shadow">
                        <div class="widget-body pb-0">
                            <div class="row d-flex align-items-center">
                                <div
                                    class="col-xl-4 col-md-4 d-flex justify-content-lg-start justify-content-md-start justify-content-center">

                                </div>
                                <div class="col-xl-4 col-md-4 d-flex justify-content-center">
                                    <div class="image-default">
                                        <img class="img-thumbnail rounded-circle" style="" src="{{ $member->image->src() }}"
                                            alt="...">
                                    </div>
                                    <div class="infos">
                                        <h2>
                                            {{ $member->name }} 
                                        </h2>
                                        <div class="location">{{ $member->permanent_address }}</div>
                                        <div class="location">{{ $member->present_address }}</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div style="font-size: 20px; padding-bottom: 5px; border-bottom: 1px solid #eeeeee; margin-bottom: 10px">
                                        সদস্যের পরিচিতি
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="td1">আইডি </td>
                                                    <td><b style="font-size: 16px">{{ bnConvert()->number($member->organization_id) }}</b></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="td1">পিতার নাম</td>
                                                    <td>{{ $member->father_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="td1">মাতার নাম</td>
                                                    <td>{{ $member->mother_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="td1">জন্ম তারিখ</td>
                                                    <td>{{ $member->date_of_birth->format('d M Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="td1">জাতীয়তা</td>
                                                    <td>{{ $member->nationality }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="td1">যোগদানের তারিখ</td>
                                                    <td>{{ bnConvert()->date($member->created_at->format('d M Y, h:i a'))}} ({{ bnConvert()->date($member->created_at->diffForHumans())}})</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                
                                                
                                                <tr>
                                                    <td class="td1">ধর্ম</td>
                                                    <td>{{ $member->religion }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="td1">বর্তমান ঠিকানা</td>
                                                    <td>{{ $member->present_address }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="td1">স্থায়ী ঠিকানা</td>
                                                    <td>{{ $member->permanent_address }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="td1">পেশা</td>
                                                    <td>{{ $member->occupation }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="td1">রক্তের গ্রুপ</td>
                                                    <td>{{ $member->blood_group }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@stop
