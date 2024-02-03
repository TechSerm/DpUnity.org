<div>
    <div class="store-card">
        <style>
            .tdTitle{
                width: 65%;
            }
            .orderTotalTable td{
                border: 1px solid #eeeeee;
                padding: 10px;
            }
        </style>
        <div class="body">
            <table class="orderTotalTable">
                <tr class="orderSummeryTableTotalTr">
                    <td class="tdTitle" colspan="2"><span>Subtotal:</span></td>
                    <td>৳ <b>{{ bnConvert()->number($totalCartPrice) }}</b></td>
                </tr>
                <tr class="orderSummeryTableTotalTr">
                    <td class="tdTitle" colspan="2"><span>Payment Method:</span></td>
                    <td> <b>Cash On Delivery</b></td>
                </tr>
                <tr class="orderSummeryTableTotalTr">
                    <td class="tdTitle" colspan="2">Shipping Charge:</td>
                    <td>৳ <b>{{ bnConvert()->number($deliveryFee) }}</b></td>
                </tr>
    
                <tr class="orderSummeryTableTotalTr">
                    <td class="tdTitle" colspan="2"><span class="badge" style="font-size: 14px">Grand Total:</span></td>
                    <td>৳ <b>{{ bnConvert()->number($totalPayablePrice) }}</b></td>
                </tr>
            </table>
        </div>
    </div>
</div>

