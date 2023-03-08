<div class="card" id="accordionExample">

    order Notest


</div>

@php
    $activities = $order->activities()->get();
@endphp

{{ $order->activities()->get() }}
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
<table class="history-table" style="width: 100%">
    <thead>
        <tr class="tr2">
            <th>Time</th>
            <th>Note</th>
            <th>Changes By</th>
        </tr>
    </thead>
    <tbody>


        @foreach ($activities as $attKey => $activitie)
            @php
                $changes = $activitie->changes;
                
            @endphp

            <tr class="">
                <td style="width: 90px"><span title="{{ $activitie->created_at }}"
                        class="badge badge-light">{{ $activitie->created_at->diffForHumans() }}</span></td>
                <td>
                    {{ $activitie->description }}
                </td>
                <td style="width: 120px"><span class="badge badge-info">{{ $activitie->causer->name ?? 'System' }}</span></td>
            </tr>
        @endforeach
    </tbody>
</table>
