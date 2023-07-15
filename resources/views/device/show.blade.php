@php
    $histories = $device->history()->with('user')->orderBy('id', 'desc')->get();
@endphp

<table class="table table-bordered" style="font-size: 14px">
    @foreach ($histories as $history)
    @php
        $data = json_decode($history->cache_data,true);
        $checkOutData = !empty($data) ? $data['checkout_info'] : [];
    @endphp
        <tr>
            <td>{{ $history->ip }}</td>
            <td><a href="{{ $history->url }}"><span class="badge badge-info"> {{ $history->shortUrl() == "" ? "/home" : $history->shortUrl() }}</span></a></td>
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
            <td>
                {{$history->user ? $history->user->name : ""}}
            </td>
        </tr>
    @endforeach


</table>
