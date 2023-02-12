@extends('layouts.app')
@section('content_header')
    <h1>Notification Device</h1>
    <form method="POST" action="admin/logout">
        @csrf


    </form>
@stop


@section('content')
    <div class="card">
        <div class="card-header"><b>Device Snapshot</b></div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $totalDevice }}" text="Total Device" icon="fas fa-gift" theme="info" />
                </div>
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $todayAddDevice }}" text="Today" icon="fas fa-gift"
                        theme="info" />
                </div>
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $weekAddDevice }}" text="Last 7 Days" icon="fas fa-gift"
                        theme="info" />
                </div>
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $monthAddDevice }}" text="Last 30 Days" icon="fas fa-gift"
                        theme="info" />
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><b>Device Visitor Snapshot</b></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $lastVisit }}" text="Last 30 Min" icon="fas fa-gift"
                        theme="success" />
                </div>
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $today }}" text="Today" icon="fas fa-gift"
                        theme="success" />
                </div>
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $weekVisit }}" text="Last 7 Days" icon="fas fa-gift"
                        theme="success" />
                </div>
                <div class="col-md-3 col-sm-6">
                    <x-adminlte-small-box title="{{ $monthVisit }}" text="Last 30 Days" icon="fas fa-gift"
                        theme="success" />
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><b>Device List Table</b></div>
        <div class="card-body">
            <div style="margin-bottom: 10px;">
                <b>My IP:</b> {{request()->ip()}}
            </div>
            <table class="table table-bordered table-responsive-md" style="width: 100%" id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>IP</th>
                        <th>Total Hits</th>
                        <th>Last Visit Time</th>
                        <th>Created At</th>
                        <th>Last Visit Page</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // DataTable
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                bStateSave: true,
                "aaSorting": [],
                idSrc: "id",
                "fnStateSave": function(oSettings, oData) {
                    Helper.storage.setItem('notificationDataTables', JSON.stringify(oData));
                },
                "fnStateLoad": function(oSettings) {
                    return JSON.parse(Helper.storage.getItem('notificationDataTables'));
                },
                ajax: "{{ route('notification_device.data') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'last_visit_ip'
                    },
                    {
                        data: 'hits'
                    },
                    {
                        data: 'last_visit_time'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'last_visit_page'
                    },
                ]
            });

        });
    </script>
@endpush
