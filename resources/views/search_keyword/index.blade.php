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
                    <table class="table table-bordered table-responsive-md" style="width: 100%" id="searchKeywordTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Key</th>
                                <th>Total Values</th>
                                <th>Values</th>
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
            $('#searchKeywordTable').DataTable({
                processing: true,
                serverSide: true,
                bStateSave: true,
                "aaSorting": [],
                idSrc: "id",
                "fnStateSave": function(oSettings, oData) {
                    Helper.storage.setItem('searchKeywordDataTables', JSON.stringify(oData));
                },
                "fnStateLoad": function(oSettings) {
                    return JSON.parse(Helper.storage.getItem('searchKeywordDataTables'));
                },
                ajax: "{{ route('search-keywords.data') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'key'
                    },
                    {
                        data: 'total_values'
                    },
                    {
                        data: 'values'
                    },
                    {
                        data: 'action'
                    },
                ]
            });

        });

        function reloadSearchKeywordDatatable(){
            $('#searchKeywordTable').DataTable().ajax.reload(null, false);
        }

        function updateSearchKeyword(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    'callback': function() {
                        reloadSearchKeywordDatatable();
                    }
                }
            });
        }

    </script>
@endpush
