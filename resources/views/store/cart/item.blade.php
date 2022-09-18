<tr style="{{ $totalQuantity <= 0 ? 'display: none' : '' }}">
    
    <td class="align-middle">
        <img src="{{ $item->image }}" height="45px" width="45px" alt="">
    </td>
    <td class="align-middle">
        <div class="" style="font-size: 13px;font-weight: bold">
            {{$item->name}}
        </div>
        <div style="font-size: 11px;font-weight: bold; color: #767575">৳ {{ convertBanglaNumber($item->price) }}  / {{ bnConvert()->number($item->quantity, false) }} {{ bnConvert()->unit($item->unit) }} </div>
        <div style="margin-top: 10px; font-size: 12px; font-weight: bold;">
            <span style="background: #f5f5f5; border: 1px solid #aaaaaa; padding: 5px 0px 5px 2px; border-radius: 5px">
                <button style="padding: 0px 5px; font-size: 11px" wire:click="decrement" class="btn btn-sm btn-warning"><i class="fa fa-minus"></i></button>
                <span style="margin-left: 5px; margin-right: 5px;">{{ convertBanglaNumber($totalQuantity) }}</span>
            <button style="padding: 0px 5px;font-size: 12px" wire:click="increment" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
            </span>
            
            <button class="btn btn-sm btn-danger" style="padding: 0px 5px; margin-left: 15px; font-size: 12px"><i class="fa fa-trash"></i> </button>
        </div>
    </td>
    <td class="align-middle" style="text-align: center; width: 20px;">
        <span class="badge badge-info">৳ {{ bnConvert()->number($totalPrice) }} <br/> <span class="badge" style="margin-top: 3px;">{{bnConvert()->number($item->quantity * $totalQuantity, false)}} {{bnConvert()->unit($item->unit)}}</span></span> 
    </td>
</tr>
