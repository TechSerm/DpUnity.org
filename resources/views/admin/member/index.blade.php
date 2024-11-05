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
                        User List
                    </div>
                </div>

                <div class="card-body">
                    <style>
                        .table>tbody>tr>td,
                        th {
                            vertical-align: middle;
                            text-align: left
                        }
                    </style>
                    <table class="table table-bordered table-responsive-md" style="width: 100%" id="myTable">
                        <thead>
                            <tr>
                                <th  style="">ID</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Approved</th>
                                <th>Registration Time</th>
                                <th>Action</th>
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
                    Helper.storage.setItem('categoryDataTables', JSON.stringify(oData));
                },
                "fnStateLoad": function(oSettings) {
                    return JSON.parse(Helper.storage.getItem('categoryDataTables'));
                },
                ajax: "{{route('admin.members.data')}}",
                columns: [
                    {data: 'id'},
                    {data: 'photo'},
                    {data: 'name'},
                    {data: 'approved'},
                    {data: 'created_at'},
                    {data: 'action'},
                ]
            });
        });

        

        function createMember(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    callback: function(response) {
                        window.location.reload();
                    }
                }
            });
        }

        function previewFile(event, imageId) {

            var output = document.getElementById(imageId);
            if (!event.target.files[0]) {
                // output.src = $('#img-preview-default').attr('src');
            } else output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
    </script>


@endpush
