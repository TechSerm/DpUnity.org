@extends('layouts.app')
@section('content_header')
    <h1>Push Notification List</h1>
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
                            <button class="btn btn-primary " data-url="{{ route('push_notifications.create') }}"
                                data-modal-title="Create Product" data-modal-size="650" data-toggle="modal">Create Push
                                Notification</button>
                        </div>
                    </div>
                    <table class="table table-bordered table-responsive-md" style="width: 100%" id="pushNotificationTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th>Url</th>
                                <th>Image</th>
                                <th>Total Notify</th>
                                <th>Total Click</th>
                                <th>Created At</th>
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
            $('#pushNotificationTable').DataTable({
                processing: true,
                serverSide: true,
                bStateSave: true,
                "aaSorting": [],
                idSrc: "id",
                "fnStateSave": function(oSettings, oData) {
                    Helper.storage.setItem('pushNotificationTable', JSON.stringify(oData));
                },
                "fnStateLoad": function(oSettings) {
                    return JSON.parse(Helper.storage.getItem('pushNotificationTable'));
                },
                ajax: "{{ route('push_notifications.data') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'body'
                    },
                    {
                        data: 'url'
                    },
                    {
                        data: 'image'
                    },
                    {
                        data: 'total_sends'
                    },
                    {
                        data: 'total_clicks', name: 'total_clicks',  orderable: true
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

        function createPushNotification(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    'callback': function() {
                        reloadPushNotificationDatatable();
                        Helper.currentModal().close();
                    }
                }
            });
        }

        function reloadPushNotificationDatatable() {
            $('#pushNotificationTable').DataTable().ajax.reload(null, false);
        }
    </script>
@endpush
