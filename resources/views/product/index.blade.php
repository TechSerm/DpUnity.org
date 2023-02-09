@extends('layouts.app')
@section('content_header')
    <h1>Products List</h1>
@stop
@section('content')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
                            @can('products.create')
                            <button class="btn btn-primary " data-url="{{ route('products.create') }}"
                                data-modal-title="Create Product" data-modal-size="650" data-toggle="modal">Create
                                Product</button>
                            @endcan
                        </div>
                    </div>
                    <table class="table table-bordered table-responsive-md" style="width: 100%" id="myTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>পণ্যের ছবি</th>
                                <th>পণ্যের নাম</th>
                                <th>ক্যাটাগরি</th>
                                <th>স্টক</th>
                                <th>অবস্থা</th>
                                <th>পাইকারি মূল্য</th>
                                <th>বাজার দর</th>
                                <th>ডেলিভারি ফী</th>
                                @if (auth()->user()->isAdmin())
                                <th>লাভ</th>
                                <th>বিবিসিনা মূল্য</th>
                                @endif
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
                ajax: "{{ route('products.data') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'image'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'categories'
                    },
                    {
                        data: 'has_stock'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'wholesale_price'
                    },
                    {
                        data: 'market_sale_price'
                    },
                    {
                        data: 'delivery_fee'
                    },
                    @if (auth()->user()->isAdmin())
                    {
                        data: 'profit'
                    },
                    {
                        data: 'price'
                    },
                    @endif
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'action'
                    },
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


        $(document).on('keyup', '#wholesale_price, #profit', function(e) {
            calculateProductPrice();
        });

        $(document).on('keyup', '#image', function(e) {
            $("#image-preview").attr("src", $("#image").val());
        });

        function calculateProductPrice() {
            let wholesalePrice = $("#wholesale_price").val();
            let profit = $("#profit").val();
            wholesalePrice = wholesalePrice ? parseInt(wholesalePrice) : 0;
            profit = profit ? parseInt(profit) : 0;
            let price = wholesalePrice + profit;
            $("#price").val(price);
        }

        $('#categories').select2({

            placeholder: 'Select an Categories',
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: "{{ route('categories.select2_data') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return response.results;
                },
                cache: true
            }
        });

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
