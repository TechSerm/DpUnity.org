<div id="invoice_area" style="text-align: center">
    <div style="margin-top: 15px;"></div>
    <div class="bg" style="width: 400px; border-width: 0px; border-style: dotted; padding: 2px;">

        <div id="iv"><b>
                Alom Brother<br/>
                Mobile: 0154154<br></b>
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
            অর্ডার নাম্বার: 42<br/>
            নাম : thohidul Terminal<br>
            বাড়ির ঠিকানা: 454<br />
            মোবাইল নাম্বার: 0415<br>
        </div>
        <div id="dot">
            <script type="text/javascript">
                for (var i = 0; i < 23; i++) {
                    document.write("<b>-</b>");
                }
                document.write("<b>Product Summery</b>");
                for (var i = 0; i < 23; i++) {
                    document.write("<b>-</b>");
                }
            </script>
        </div>
        <style type="text/css">
            .invoice_table {
                padding-right: 30px;

            }
        </style>


        <table border="0px" width="100%">
            <tr>
                <th class="invoice_table">
                    <center>No</center>
                </th>
                <th class="invoice_table">
                    <center>Name</center>
                </th>
                <th class="invoice_table">
                    <center>Quntity</center>
                </th>
                <th class="invoice_table">
                    <center>Price</center>
                </th>
            </tr>

            @php
                $items = $order->items;
            @endphp

            @foreach ($items as $key => $item)
            <tr>
                <td class="invoice_table">
                    <center>{{$key + 1}}</center>
                </td>
                <td class="invoice_table">
                    <center>{{$item->name}}</center>
                </td>
                <td class="invoice_table">
                    <center>{{$item->quantity}}</center>
                </td>
                <td class="invoice_table">
                    <center>{{$item->price}}</center>
                </td>
            </tr>
            @endforeach


            <tr class="line">
                <td class="invoice_table">
                    <center></center>
                </td>
                <td class="invoice_table">
                    <center></center>
                </td>
                <td class="invoice_table">
                    <center><b>Sub Total: </b></center>
                </td>
                <td class="invoice_table">
                    <center><b> taka</b></center>
                </td>

            </tr>

            <tr>
                <td class="invoice_table">
                    <center></center>
                </td>
                <td class="invoice_table">
                    <center></center>
                </td>
                <td class="invoice_table">
                    <center><b>Advanced: </b></center>
                </td>
                <td class="invoice_table">
                    <center><b> taka</b></center>
                </td>

            </tr>
            <tr>
                <td class="invoice_table">
                    <center></center>
                </td>
                <td class="invoice_table">
                    <center></center>
                </td>
                <td class="invoice_table">
                    <center><b>Due: </b></center>
                </td>
                <td class="invoice_table">
                    <center><b> taka</b></center>
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
        .invoice_table{
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
            background: url(https://www.msoutlook.info/pictures/bgconfidential.png)repeat 0px 0px;
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
