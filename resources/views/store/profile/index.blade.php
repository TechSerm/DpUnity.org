@extends('store.layout.layout')

@section('content')
    <style>
        .border-success {
            border: 1px solid #02AB7D;
        }
    </style>
    <div class="row">
        <div class="col-md-4">
            <div class="store-card">
                <div class="p-4 text-center position-relative">
                    <!-- Image -->
                    <span class="avatar avatar-md mb-3">
                        <img height="80px"
                            src="data:image/png;base64,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"
                            class="image rounded-circle">
                    </span>
                    <!-- Name -->
                    <h4 class="h5 fs-14 mb-1 fw-700 text-dark">{{auth()->user()->name}}</h4>
                    <div class="">{{auth()->user()->phone}}</div>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-8">
            <div class="store-card" style="font-weight: bold; padding: 10px; font-size: 14px;">
                আপনি বিবিসেনার মাধ্যমে বিক্রি করতে পেরেছেন
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="store-card pt-3 pb-3" style="p-5">
                        <div class="text-center">
                            <h4>১,২৩,০০০ ৳ </h4>
                            <span class="badge badge-success normal-padding radius-5 mb-2">
                                মোট
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-6">
                    <div class="store-card pt-3 pb-3" style="p-5">
                        <div class="text-center">
                            <h4>১,২৩,০০০ ৳ </h4>
                            <span class="badge badge-primary normal-padding radius-5 mb-2">
                                এই মাসে
                            </span>
                        </div>
                    </div>
                </div>
            </div> --}}


        </div>
        <div class="col-md-4">
            <div class="sidemnenu">

                <!-- logout -->
                <a data-turbolinks="false" href="{{ route('admin.home') }}" class="btn btn-primary btn-block fs-14 fw-700 mb-md-0 mt-2"
                    style="border-radius: 25px;">Go To Admin Panel</a>
                
                    <form method="POST" data-function="Store.auth.logout(form)" action="{{route('logout')}}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block fs-14 fw-700 mb-5 mb-md-0 mt-1"
                        style="border-radius: 25px;" onclick="">
                            Logout
                    </button>
                    </form>

            </div>
        </div>
    </div>


@stop
