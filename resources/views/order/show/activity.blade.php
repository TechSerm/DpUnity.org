<div class="table-responsive mb-3">
    
    <div class="body">
        @php
            $activities = $order->activityLogService()->getProcessLog();
        @endphp
        <style>
            .history-table table,
            th,
            td {
                border: 1px solid #dddddd;
                text-align: center;
                padding: 20px;
            }





            .marker-success {
                background: #ABF2BC;
                font-size: 13px;
            }

            .marker-danger {
                background: #FFC1C0;
                font-size: 13px;
            }

            .marker-info {
                font-weight: bold;
                background: #DDF4FF;
                margin-right: 3px;
                font-size: 13px;
            }

            .history-table i {
                font-size: 13px;
            }
        </style>
        <table class="table history-table table-striped" style="width: 100%">
            <thead>
                <tr class="tr2">
                    <th>Created On</th>
                    <th>Description</th>
                    <th>Changes</th>
                    <th>Changes By</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($activities as $attKey => $activitie)
                    @php
                       // $changes = $activitie->changes;
                        
                    @endphp

                    <tr class="">
                        <td style="width: 90px"><span title="{{ $activitie->created_at }}"
                                class="badge badge-light">{{ $activitie->created_at->diffForHumans() }}</span></td>
                        <td style="width: 140px">
                            {!! $activitie->description !!}
                        </td>
                        <td>
                            {!! $activitie->changes !!}
                        </td>
                        <td style="width: 120px"><span
                                class="badge badge-info">{{ $activitie->created_by }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
