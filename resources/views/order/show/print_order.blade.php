<div id="invoice_area" style="">
    <div style="margin-top: 15px;"></div>
    <div class="bg" style="text-align: center;width: 400px; border-width: 0px; border-style: dotted; padding: 2px;">

        <div id="iv"><b>
                বিবিসেনা অনলাইন শপ<br /></b>
            ঘরে বসেই করুন আপনার বাজার<br /><b>
        </div>

        <div id="dot">
            <script type="text/javascript">
                for (var i = 0; i < 25; i++) {
                    document.write("<b>-</b>");
                }
                document.write("<b>Customer Info</b>");
                for (var i = 0; i < 25; i++) {
                    document.write("<b>-</b>");
                }
            </script>

        </div>
        <div id="possition_sidee" style="text-align: left; margin-left: 15px">
            অর্ডার নাম্বার: {{ $order->id }}<br />
            নাম : {{ $order->name }}<br>
            বাড়ির ঠিকানা: {{ $order->address }}<br />
            মোবাইল নাম্বার: {{ $order->mobile }}<br>
        </div>
        <div id="dot">
            <script type="text/javascript">
                for (var i = 0; i < 20; i++) {
                    document.write("<b>-</b>");
                }
                document.write("<b>ক্রয়কৃত পণ্যের তালিকা</b>");
                for (var i = 0; i < 20; i++) {
                    document.write("<b>-</b>");
                }
            </script>
        </div>
        <style type="text/css">
            .invoice_table {
                font-size: 13px;

            }
        </style>


        <table border="0px" width="100%">
            <tr>
                <th class="invoice_table">
                    <center>নাম</center>
                </th>
                <th class="invoice_table">
                    <center>পরিমান</center>
                </th>
                <th class="invoice_table">
                    <center>দর</center>
                </th>
                <th class="invoice_table">
                    <center>মোট</center>
                </th>
            </tr>

            @php
                $items = $order->items;
            @endphp

            @foreach ($items as $key => $item)
                <tr>
                    <td class="invoice_table">
                        <center>{{ $item->name }} - ({{bnConvert()->number($item->unit_quantity)}} {{bnConvert()->unit($item->unit)}})</center>
                    </td>
                    <td class="invoice_table">
                        <center>{{ bnConvert()->number($item->quantity) }}</center>
                    </td>
                    <td class="invoice_table">
                        <center>{{ bnConvert()->number($item->price) }} টাকা</center>
                    </td>
                    <td class="invoice_table">
                        <center>{{ bnConvert()->number($item->price) }} টাকা</center>
                    </td>
                </tr>
            @endforeach


            <tr class="line">
                
                <td colspan="2" class="invoice_table" style="text-align: right">
                    <b>পণ্যের মূল্য: </b>
                </td>
                <td colspan="2" class="invoice_table">
                    <center><b>{{ bnConvert()->number($order->subtotal) }} </b>টাকা</center>
                </td>

            </tr>

            <tr>
                <td colspan="2" class="invoice_table" style="text-align: right">
                    <b>ডেলিভারি ফী: </b>
                </td>
                <td colspan="2"  class="invoice_table">
                    <center><b>{{ bnConvert()->number($order->delivery_fee) }} </b>টাকা</center>
                </td>

            </tr>
            <tr>
               
                <td colspan="2" class="invoice_table" style="text-align: right">
                    <b>সর্বমোট: </b>
                </td>
                <td colspan="2" class="invoice_table">
                    <center><b>{{ bnConvert()->number($order->total) }} </b>টাকা</center>
                </td>

            </tr>

        </table>

        <br>


        <br />



    </div>


    <style type="text/css">
        .line {
            border-top-width: 2px;
            border-bottom-width: 0px;
            border-left-width: 0px;
            border-right-width: 0px;
            border-style: dotted;
            padding: 10px;
            margin-top: 10px;
            margin-left: 10px;
            margin-right: 20px;
            width: 100%;
        }

        .invoice_table {
            border: 1px solid #eeeeee;
        }
    </style>

</div>


<center>
    <br />
    <button class="btn btn-success" onclick="print_page()" />Print </button>
</center>



<style type="text/css">
    .bg {
        font-family: 'Arsenal', sans-serif;
        background: #fff;
        background-size: 20%;

    }
</style>

</div>
<script type="text/javascript">
    function print_page() {
        printDiv("invoice_area");
    }

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
