<tr style="{{ $item->cart_quantity <= 0 ? 'display: none' : '' }}">
    
    <td class="align-middle">
        <img src="{{ $item->image }}" height="45px" width="45px" alt="">
    </td>
    <td class="align-middle">
        <div class="" style="font-size: 13px;font-weight: bold">
            {{$item->name}}
        </div>
        <div style="font-size: 11px;font-weight: bold; color: #767575">৳ {{ bnConvert()->number($item->price) }}  / {{ bnConvert()->number($item->quantity, false) }} {{ bnConvert()->unit($item->unit) }} </div>
    </td>
    <td class="align-middle" style="text-align: center; width: 20px;">
        <span class="badge badge-primary">৳ {{ bnConvert()->number($item->cart_total_price) }}</span> 
    </td>
</tr>