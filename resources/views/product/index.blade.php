@extends('layouts.app')
@section('content')

    <div class="row" style="">

        <div class="col-md-12">
            {{-- <div class="card">
                <div class="card-header">
                    Filter
                </div>
                <div class="card-body">
                    @include('product.filter')
                </div>
            </div> --}}
            <div class="card" style="margin-top: 10px;">
                <div class="card-header">
                    <div class="row">
                        <div class="pull-left">
                            Product List
                        </div>
                        <div class="pull-right">
                            Test
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>Regular Price</th>
                                <th>Sale Price</th>
                                <th>Hot Deals</th>
                                <th>Status</th>
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


        var productDatatable = $('#myTable').DataTable({
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
            ajax: {
                url: "{{ route('products.data') }}",
                data: function(d) {
                    d.product_id = $('#filter_product_id').val();
                    d.product_name = $('#product_name').val();
                    d.has_stock = $('#filter_has_stock').val();
                    d.status = $('#filter_status').val();
                    d.vendor = $('#filter_vendor').val();
                    d.category = $('#filter_category').val();

                }
            },
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
                    data: 'status'
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
                    data: 'action'
                },
            ]
        });



        function productTableFilter() {
            productDatatable.draw();
        }

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
