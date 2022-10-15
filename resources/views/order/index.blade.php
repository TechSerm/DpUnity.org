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
                                <th>অর্ডার নম্বর</th>
                                <th>নাম</th>
                                <th>মোবাইল</th>
                                <th>স্টেটাস</th>
                                <th>পণ্যের দাম </th>
                                <th>ডেলিভারি ফি</th>
                                <th>সর্বমোট</th>
                                <th>সর্বমোট পাইকারি দাম</th>
                                <th>পণ্যে লাভ</th>
                                <th>অর্ডার করা হয়েছে</th>
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
                    {
                        data: 'name'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'status'
                    },
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
                        data: 'wholesale_total'
                    },  
                    {
                        data: 'products_profit'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'action'
                    },
                ]
            });

        });
    </script>
@endpush
