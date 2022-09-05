<style>
    .history-table table,
    th,
    td {
        border: 1px solid #dddddd;
        text-align: center;
        padding: 20px;
    }



    

    .marker-success{
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
            <th>#</th>
            <th>Event</th>
            <th>Time</th>
            <th>Changes</th>
            <th>Changes By</th>
        </tr>
    </thead>
    <tbody>


        @foreach ($activities as $attKey => $activitie)
            @php
                $changes = $activitie->changes;
                $attributes = $changes['attributes'];
                $oldAttributes = isset($changes['old']) ? $changes['old'] : [];
                $totalColumn = count($attributes);
                $firstKeyName = array_key_first($attributes);
                $class = $attKey % 2 == 1 ? 'tdBg1' : 'tdBg2';
                
            @endphp

            <tr class="{{$class}}">
                <td>{{ $activitie->id }}</td>
                <td>
                    @if ($activitie->event == 'created')
                        <span class="badge badge-success">{{ $activitie->event }}</span>
                    @endif
                    @if ($activitie->event == 'updated')
                        <span class="badge badge-primary">{{ $activitie->event }}</span>
                    @endif

                    @if ($activitie->event == 'deleted')
                        <span class="badge badge-danger">{{ $activitie->event }}</span>
                    @endif
                    
                </td>
                <!-- This cell will take up space on
                two rows -->
                <td>
                    <span title="{{ $activitie->created_at }}" class="badge badge-light">{{ $activitie->created_at->diffForHumans() }}</span>
                </td>
                <td style="text-align: left" style="padding-left: 15px;">
                    @foreach ($attributes as $key => $value)
                    @php
                        $oldAttr = isset($oldAttributes[$key]) ? $oldAttributes[$key]  : '';
                    @endphp
                    <span class="marker-info">[{{$key}}]</span>
                    @if ($oldAttr != '')
                        <span class="marker-danger" style="padding: 0px 3px 0px 3px">{{ isset($oldAttributes[$key]) ? $oldAttributes[$key]  : '' }}</span> <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    @endif
                    
                    <span class="marker-success" style="padding: 1px">{{ $value }}</span><br/>
                    
                    
                    @endforeach
                </td> 
                
                <td><span class="badge badge-info">{{$activitie->causer->name ?? 'System'}}</span></td>
            </tr>
        @endforeach
    </tbody>
</table>
