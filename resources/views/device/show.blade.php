@php
    $histories = $device->history()->orderBy('id', 'desc')->get();
@endphp

<table class="table table-bordered">



    @foreach ($histories as $history)
    @php
        $data = json_decode($history->cache_data,true);
        $checkOutData = !empty($data) ? $data['checkout_info'] : [];
    @endphp
        <tr>
            <td>{{ $history->ip }}</td>
            <td>{{ $history->url }}</td>
            <td>
                @if (!empty($checkOutData))
                    {{$checkOutData['fullName']}}<br/>
                    {{$checkOutData['address']}}<br/>
                    {{$checkOutData['phone']}}
                @endif
            </td>
            <td>
                {{$history->created_at->format('d M y, G:i:s') . ' (' . $history->created_at->diffForHumans() . ')'}}
            </td>
        </tr>
    @endforeach


</table>
