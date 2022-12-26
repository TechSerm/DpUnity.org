<div class="orderTotalArea">
    <table class="orderTotalTable">
        <tr class="orderSummeryTableTotalTr">
            <td colspan="2"><span>পণ্যের মূল্য:</span>
            </td>
            <td>৳ <b>{{ bnConvert()->number($totalCartPrice) }}</b></td>
        </tr>
        <tr class="orderSummeryTableTotalTr">
            <td colspan="2">ডেলিভারি ফী:</td>
            <td>৳ <b>{{ bnConvert()->number($deliveryFee) }}</b></td>
        </tr>

        <tr class="orderSummeryTableTotalTr">
            <td colspan="2"><span class="badge" style="font-size: 14px">সর্বমোট:</span></td>
            <td>৳ <b>{{ bnConvert()->number($totalPayablePrice) }}</b></td>
        </tr>
    </table>
    <div class="totalMessageArea">
        ডেলিভারি এর সময় আপনাকে <span class="badge badge-success" style="font-size: 14px">{{bnConvert()->number($totalPayablePrice)}}</span> টাকা পরিশোধ করতে হবে
    </div>
</div>