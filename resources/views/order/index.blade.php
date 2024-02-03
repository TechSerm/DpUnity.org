@extends('layouts.app')
@section('content_header')
    <h1>Orders List</h1>
@stop
@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <style>
                        .table>tbody>tr>td,
                        th {
                            vertical-align: middle;
                            text-align: center
                        }
                    </style>
                    <table class="table table-bordered table-responsive-md" style="width: 100%" id="myTable">
                        <thead>
                            <tr>
                                <th>Order ID</th>

                                <th>Shipping Name</th>
                                <th>Shippeing Address</th>
                                <th>Shipping Mobile Number</th>

                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Payment Status</th>
    
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        if (performance.navigation.type !== performance.navigation.TYPE_RELOAD) {
            localStorage.clear();
        }

        $(document).ready(function() {
            // DataTable
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                bStateSave: true,
                "aaSorting": [],
                idSrc: "id",
                "fnStateSave": function(oSettings, oData) {
                    Helper.storage.setItem('productDataTables', JSON.stringify(oData));
                },
                "fnStateLoad": function(oSettings) {
                    return JSON.parse(Helper.storage.getItem('productDataTables'));
                },
                ajax: "{{ route('orders.data') }}",
                columns: [{
                        data: 'id'
                    },
                    @if (!auth()->user()->isCashier())
                    @if (auth()->user()->isAdmin())
                    {
                        data: 'name'
                    },
                    {
                        data: 'phone'
                    },
                    @endif
                    {
                        data: 'status'
                    },
                    {
                        data: 'wholesale_total'
                    },  
                    @if (auth()->user()->isAdmin())
                    {
                        data: 'subtotal'
                    },
                    {
                        data: 'delivery_fee'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'products_profit'
                    },
                    @endif
                    {
                        data: 'created_at'
                    },
                    @endif
                    {
                        data: 'action'
                    },
                ]
            });

        });
    </script>
@endpush
