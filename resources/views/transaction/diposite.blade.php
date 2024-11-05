@extends('admin.layout')
@section('content_header')
@stop
@section('content')

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
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
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #258391;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #258391;
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

    <div class="row">

        <div class="col-md-12" style="margin-top: 10px;">
            <div class="card">
                <div class="card-header align-items-center">
                    <div class="float-left" style="padding-top: 7px;">
                        জমার তালিকা
                    </div>
                </div>
                <div class="card-body">
                    <x-adminlte-small-box title="{{ bnConvert()->number($transactions->sum('amount')) }} টাকা" text="সর্বমোট জমা" icon="fas fa-shopping-cart"
                        theme="success" />
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <button class="mb-3 btn btn-primary" data-modal-title="জমা করুন" data-toggle="modal"
                            data-url="{{ route('admin.transaction.diposite.create') }}">জমা
                            করুন</button>
                    </div>
                    <style>
                        .table>tbody>tr>td,
                        th {
                            vertical-align: middle;
                            text-align: left
                        }
                    </style>
                    <table class="table table-bordered table-responsive-md" style="width: 100%" id="dipositeTable">
                        <thead>
                            <tr>
                                <th style="">জমা আইডি</th>
                                <th>ছবি</th>
                                <th>মেম্বারের নাম</th>
                                <th>মোবাইল</th>
                                <th>পরিমাণ</th>
                                <th>জমা করেছে</th>
                                <th>তারিখ</th>
                                <th></th>
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
            $('#dipositeTable').DataTable({
                processing: true,
                serverSide: true,
                bStateSave: true,
                "aaSorting": [],
                idSrc: "id",
                "fnStateSave": function(oSettings, oData) {
                    Helper.storage.setItem('dipositeDataTables', JSON.stringify(oData));
                },
                "fnStateLoad": function(oSettings) {
                    return JSON.parse(Helper.storage.getItem('dipositeDataTables'));
                },
                ajax: "{{ route('admin.transaction.diposite.data') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'photo'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'mobile'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'diposite_by'
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

        function reloadTransactionDatatable() {
            $('#dipositeTable').DataTable().ajax.reload(null, false);
        }

        function createDiposite(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    callback: function(response) {
                        window.location.reload();
                    }
                }
            });
        }
    </script>
@endpush
