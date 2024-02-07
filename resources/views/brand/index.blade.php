@extends('layouts.app')
@section('title', 'Brands')
@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="card mt-2">
                <div class="card-header align-items-center">
                    <div class="float-left" style="padding-top: 7px;">
                        Brand List
                    </div>
                    <div class="float-right">
                        <div class="align-self-end ml-auto">
                            <button class="btn btn-primary " data-url="{{ route('brands.create') }}"
                                data-modal-title="Create Brand" data-modal-size="650" data-toggle="modal"><i class="fa fa-plus"></i> Create
                                Brand</button>
                        </div>
                    </div>
                </div>
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
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
                    Helper.storage.setItem('brandDataTables', JSON.stringify(oData));
                },
                "fnStateLoad": function(oSettings) {
                    return JSON.parse(Helper.storage.getItem('brandDataTables'));
                },
                ajax: "{{ route('brands.data') }}",
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'image'},
                    {data: 'updated_at'},
                    {data: 'action'},
                ]
            });

        });

        function createProduct(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    'callback': function() {
                        $('#myTable').DataTable().ajax.reload();
                        Helper.currentModal().close();
                    }
                }
            });
        }

        function reloadProductDatatable() {
            $('#myTable').DataTable().ajax.reload(null, false);
        }

        function updateProduct(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    'callback': function() {
                        $('#myTable').DataTable().ajax.reload(null, false);
                    }
                }
            });
        }

        function previewFile(event) {

            var output = document.getElementById('image-preview');
            if (!event.target.files[0]) {
                // output.src = $('#img-preview-default').attr('src');
            } else output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
    </script>
@endpush
