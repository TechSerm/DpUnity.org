@extends('layouts.app')
@section('content_header')
    <h1>Dashboard</h1>
@stop


@section('content')

    @php
        $startDate = \Carbon\Carbon::create(request()->start_date);
        $endDate = \Carbon\Carbon::create(request()->end_date);
    @endphp


    <div class="card">
        <div class="card-header"><b>Product Snapshot</b></div>
        <div class="card-body">
            @include('dashboard.product_area')
        </div>
    </div>

    <div class="card">
        <div class="card-header"><b>Order Report</b></div>
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <input type="date" id="startDate" value="{{ $startDate->format('Y-m-d') }}" class="form-control mb-1">
                </div>
                <div class="col-md-3">
                    <input type="date" id="endDate" value="{{ $endDate->format('Y-m-d') }}" class="form-control mb-1">
                </div>
                <div class="col-md-3">
                    <select name="" class="form-control mb-1" id="vendorSelect">
                        <option value="">All Vendor</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" onclick="filterDashboardOrder()">Filter</button>
                </div>
            </div>
        </div>
        <div class="card-header">
            <b>{{ $startDate->format('d M, Y') }}</b> - <b>{{ $endDate->format('d M, Y') }}</b>
        </div>
        <div class="card-body">
            @include('dashboard.order_area')
        </div>
    </div>
    <script>
        function filterDashboardOrder() {
            startDate = $("#startDate").val();
            endDate = $("#endDate").val();
            vendorId = $("#vendorSelect").val();
            if (startDate == "" || endDate == "") {
                alert("Please select date");
                return;
            }
            var url = new URL(window.location.href);
            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            url.searchParams.set('vendor', vendorId);

            window.location.href = url;
        }
    </script>

@endsection
