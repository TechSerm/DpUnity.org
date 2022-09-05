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
                                <th>Order No</th>
                                <th>Status</th>
                                <th>Total Price</th>
                                <th>Total Whole Sale Price</th>
                                <th>Delivery Fee</th>
                                <th>Total</th>
                                <th>Total Profit</th>
                                <th>Last Update</th>
                                <th style="width: 10%">Action</th>
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
                        data: 'woo_id'
                    },

                    {
                        data: 'order_status'
                    },
                    {
                        data: 'subtotal'
                    },
                    {
                        data: 'wholesale_total'
                    },
                    {
                        data: 'shipping_total'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'profit'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'action'
                    },
                ]
            });

        });
    </script>
@endpush
