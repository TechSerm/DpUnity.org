@extends('layouts.app')
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
                <div class="col-md-2">
                    <input type="date" id="startDate" value="{{ $startDate->format('Y-m-d') }}"
                        class="form-control mb-1">
                </div>
                <div class="col-md-2">
                    <input type="date" id="endDate" value="{{ $endDate->format('Y-m-d') }}" class="form-control mb-1">
                </div>
                <div class="col-md-2" style="{{ !auth()->user()->isAdmin() ? 'display: none' : ''}}">
                    <select name="" class="form-control mb-1" id="vendorSelect">
                        @if(!auth()->user()->isVendor())
                        <option value="">All Vendor</option>
                        @endif
                        @foreach ($vendors as $vendor)
                            @if (auth()->user()->isAdmin())
                                <option value="{{$vendor->id}}" {{request()->vendor == $vendor->id ? 'selected' : ''}}>{{$vendor->name}}</option>
                            @elseif (auth()->user()->isVendor() && auth()->user()->id == $vendor->id)
                                <option value="{{$vendor->id}}" {{request()->vendor == $vendor->id ? 'selected' : ''}}>{{$vendor->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2" style="{{!auth()->user()->isAdmin() ? 'display: none' : ''}}">
                    <select name="" class="form-control mb-1" id="orderTypeSelect">
                        @if(auth()->user()->isAdmin())
                        <option value="total" {{request()->order_type == 'total' ? 'selected' : ''}}>Total</option>
                        <option value="subtotal" {{request()->order_type == 'subtotal' ? 'selected' : ''}}>Product Price</option>
                        <option value="delivery_fee" {{request()->order_type == 'delivery_fee' ? 'selected' : ''}}>Delivery Fee</option>
                        @endif
                        <option value="wholesale_total" {{request()->order_type == 'wholesale_total' ? 'selected' : ''}}>Wholesale Price</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" onclick="filterDashboardOrder()">Filter</button>
                </div>
            </div>
        </div>
        <div class="card-header">
            <b>{{ bnConvert()->date($startDate->format('d M, Y')) }}</b> -
            <b>{{ bnConvert()->date($endDate->format('d M, Y')) }}</b>
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
