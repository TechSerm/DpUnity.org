


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
            font-size: 16px;
        }
        </style>
    <td class="align-middle" style="padding: 10px; width: 110px;">
        <img src="{{ $item->image }}" class="img-thumbnail" height="100px" width="100px" alt="">
    </td>
    <td class="">
        <div class="" style="font-size: 15px;font-weight: bold">
            {{$item->name}}
        </div>
        <div style="font-size: 13px;font-weight: bold; color: #767575; margin-top: 0px">৳ {{ convertBanglaNumber($item->price) }} </div>
        <div style="margin-top: 10px; font-size: 14px; font-weight: bold;">
            <span style="background: #f5f5f5; border: 1px solid #aaaaaa; padding: 3px 2px 5px 2px; border-radius: 5px">
                <button style="padding: 0px 5px; font-size: 13px" wire:click="decrement" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button>
                <span style="margin-left: 5px; margin-right: 5px;">{{ convertBanglaNumber($totalQuantity) }}</span>
                <button style="padding: 0px 5px;font-size: 13px" wire:click="increment" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>

        </span>
        </div>
    </td>
    <td class="align-middle" style="text-align: center; width: 20px;">
        <span class="badge badge-info" style="min-width: 40px; font-size: 13px;">৳ {{ bnConvert()->number($totalPrice) }}</span> 
    </td>
</tr>
