


<tr style="{{ $totalQuantity <= 0 ? 'display: none' : '' }}" class="cartTr">
    <style>
        .cartTr{
            /* box-shadow: 0px 0px 5px rgba(70, 8, 86, 0.3);  */
            border:1px dashed #eeeeee;
            border-width: 0px 0px 1px 0px!important;
            margin-bottom: 6px; 
            display:table-row;
            width: 100%;
        }
        .cartTr td{
            /* border: 1px solid #000000; */
        }
        </style>
    <td class="align-middle" style="padding: 5px">
        <img src="{{ $item->image }}" height="70px" width="70px" alt="">
    </td>
    <td class="align-middle">
        <div class="" style="font-size: 13px;font-weight: bold">
            {{$item->name}}
        </div>
        <div style="font-size: 11px;font-weight: bold; color: #767575">৳ {{ convertBanglaNumber($item->price) }}  / {{ bnConvert()->number($item->quantity, false) }} {{ bnConvert()->unit($item->unit) }} </div>
        <div style="margin-top: 10px; font-size: 12px; font-weight: bold;">
            <span style="background: #f5f5f5; border: 1px solid #aaaaaa; padding: 3px 2px 5px 2px; border-radius: 5px">
            @if (!$item->isFree())
                <button style="padding: 0px 5px; font-size: 11px" wire:click="decrement" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button>
            @endif
            
                <span style="margin-left: 5px; margin-right: 5px;">{{ convertBanglaNumber($totalQuantity) }}</span>
            @if ($item->isFree())
                <button style="padding: 0px 5px; font-size: 11px" wire:click="decrement" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
            @endif
            @if (!$item->isFree())
                <button style="padding: 0px 5px;font-size: 12px" wire:click="increment" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
            @endif    
        </span>
        </div>
    </td>
    <td class="align-middle" style="text-align: center; width: 20px;">
        <span class="badge badge-info" style="min-width: 40px">৳ {{ bnConvert()->number($totalPrice) }}</span> 
    </td>
</tr>
