@extends('layouts.app')
@section('title', 'Order Report')
@section('content_header')
    <h1>Orders Report</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">Summary</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $totalOrder }}" text="All Orders" icon="fas fa-shopping-cart"
                        theme="info" />
                </div>
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $totalSuccessfullOrder }}" text="Completed" icon="fas fa-check"
                        theme="success" />
                </div>
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $totalProcessingOrder }}" text="Processing" icon="fa fa-ship"
                        theme="warning" />
                </div>
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $totalCanceledOrder }}" text="Canceled" icon="fas fa-times"
                        theme="danger" />
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Filter</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="label mb-2">
                        <b>To Date</b>
                    </div>
                    <input type="date" value="{{ request()->start_date }}" id="startDate" class="form-control">
                </div>
                <div class="col-md-3">
                    <div class="label mb-2">
                        <b>Form Date</b>
                    </div>
                    <input type="date" value="{{ request()->end_date }}" id="endDate" class="form-control">
                </div>
                <div class="col-md-3">
                    <div class="label mb-2">
                        <b> Status</b>
                    </div>
                    <select name="" id="statusSelect" class="form-control">
                        <option value="">Select Status</option>

                        @foreach ($orderStatus as $status)
                            <option value="{{ $status }}" {{ request()->status == $status ? 'selected' : '' }}>
                                {{ $status }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-3">
                    <div class="label">

                    </div>
                    <button class="btn btn-primary" style="margin-top: 30px;"
                        onclick="filterProductReport()">Filter</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Product List</div>
        <div class="card-body">
            <table class="table table-bordered mb-2">
                <tr>
                    <th>Order Id</th>
                    <th>Date</th>
                    <th>Shipping Name</th>
                    <th>Shipping Address</th>
                    <th>Shipping Mobile Number</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                </tr>

                @foreach ($orders as $order)
                    <tr>
                        <td><a href="{{ route('orders.show', ['order' => $order->id]) }}">{{ $order->id }}</a></td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{!! $order->status->badge() !!}</td>
                        <td>{!! $order->payment_status->badge() !!}</td>
                    </tr>
                @endforeach
            </table>
            <div class="float-right">
                {{ $orders->appends(request()->input())->links() }}
            </div>

        </div>
    </div>

@stop

@push('scripts')
    <script>
        function filterProductReport() {
            startDate = $("#startDate").val();
            endDate = $("#endDate").val();
            status = $("#statusSelect").val();

            var url = new URL(window.location.href);
            url = url.origin + url.pathname;
            url = new URL(url);
            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            url.searchParams.set('status', status);

            window.location.href = url;
        }
    </script>
@endpush
