<div>

    <style>
        .orderTotalArea {
            background-color: #f7f7f7;
            padding: 15px;
            border: 1px solid #eeeeee;
            box-shadow: -1px -2px 18px -5px rgba(170,170,170,1);

            border-radius: 5px;
        }

        .orderTotalTable {
            width: 100%;
            margin: 0;
            padding: 0;
            text-align: right;
            font-size: 14px;
        }

        .orderSummeryTable td{
            min-width: 50px;
        }

        .orderSummeryTable {
            font-family: 'SolaimanLipi', Arial, sans-serif;
            text-align: justify;
            box-sizing: border-box;
        }

        .orderSummeryTableTotalTr {
            text-align: right;
        }

        .totalMessageArea {
            border: 1px solid #dddddd;
            background: #eeeeee;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            border-radius: 5px;
            padding: 10px 5px 10px 5px;

        }

        
    </style>
    <div class="">
        <table class="table table-borderless orderSummeryTable">
            @foreach ($items as $key => $item)
                @livewire('cart.cart-item', ['item' => $item])
            @endforeach
        </table>
        @livewire('cart.cart-subtotal-area')
    </div>
    
</div>
