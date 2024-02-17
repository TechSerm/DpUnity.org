@extends('layouts.app')
@section('title', 'Dashboard')
@section('content_header')
    <h1>Dashboard</h1>
    <form method="POST" action="{{route('logout')}}">
        @csrf

        <a href="" class="btn btn-primary" onclick="event.preventDefault(); this.closest('form').submit();">
            Logout
        </a>
    </form>
@stop


@section('content')

    <div class="card">
        <div class="card-header"><b>Product Snapshot</b></div>
        <div class="card-body">
            @include('dashboard.product_area')
        </div>
    </div>

    <div class="card">
        <div class="card-header"><b>Order Snapshot</b></div>
        <div class="card-body">
            @include('dashboard.order_area')
        </div>
    </div>
    
    <script>
        function filterDashboardOrder() {
            startDate = $("#startDate").val();
            endDate = $("#endDate").val();
            vendorId = $("#vendorSelect").val();
            orderTypeSelect = $("#orderTypeSelect").val();
            if (startDate == "" || endDate == "") {
                alert("Please select date");
                return;
            }
            var url = new URL(window.location.href);
            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            url.searchParams.set('vendor', vendorId);
            url.searchParams.set('order_type', orderTypeSelect);

            window.location.href = url;
        }
    </script>

@endsection
