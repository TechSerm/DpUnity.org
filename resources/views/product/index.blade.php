@extends('layouts.app')
@section('title', 'Products')
@section('content')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 53px;
        height: 26px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 23px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #27ae60;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #27ae60;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
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
                    <div class="float-left" style="padding-top: 7px;">
                        Product List
                    </div>
                    <div class="float-right">
                        <button class="btn btn-primary " data-url="{{ route('products.create') }}"
                            data-modal-title="Create Product" data-modal-size="650" data-toggle="modal">
                            <i class="fa fa-plus"></i> Add Product
                        </button>
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
                    data: 'regular_price'
                },
                {
                    data: 'sale_price'
                },
                {
                    data: 'has_hot_deals'
                },
                {
                    data: 'status'
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
