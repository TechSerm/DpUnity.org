@extends('layouts.app')
@section('content_header')
    <h1>Category List</h1>
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
                    <div class="row">
                        <div class="align-self-end ml-auto mb-4">
                            <button class="btn btn-primary " data-url="{{ route('shippings.create') }}"
                                data-modal-title="Create Shipping" data-modal-size="650" data-toggle="modal">Create
                                Shipping</button>
                        </div>
                    </div>
                    <table class="table table-bordered table-responsive-md" style="width: 100%" id="shippingTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th> Name</th>
                                <th>Last Update</th>
                                <th>Last Update</th>
                                <th>Last Update</th>
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
            $('#shippingTable').DataTable({
                processing: true,
                serverSide: true,
                bStateSave: true,
                "aaSorting": [],
                idSrc: "id",
                "fnStateSave": function(oSettings, oData) {
                    Helper.storage.setItem('ShippingDataTables', JSON.stringify(oData));
                },
                "fnStateLoad": function(oSettings) {
                    return JSON.parse(Helper.storage.getItem('ShippingDataTables'));
                },
                ajax: "{{ route('shippings.data') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'area_class'
                    },
                    {
                        data: 'product_class'
                    },
                    {
                        data: 'calculation_type'
                    },
                    {
                        data: 'cost_for_each_quantity'
                    },
                    {
                        data: 'updated_at'
                    },
                ]
            });
        });

        function createProduct(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    'callback': function() {
                        $('#shippingTable').DataTable().ajax.reload();
                        Helper.currentModal().close();
                    }
                }
            });
        }

        function reloadProductDatatable() {
            $('#shippingTable').DataTable().ajax.reload(null, false);
        }

        function updateProduct(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    'callback': function() {
                        $('#shippingTable').DataTable().ajax.reload(null, false);
                    }
                }
            });
        }
    </script>
@endpush
