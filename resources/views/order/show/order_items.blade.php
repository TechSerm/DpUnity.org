@php
    $items = $order->items;
@endphp

<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th style="text-align: left">Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Wholesale Price</th>
        <th>Profit</th>
        <th>Total</th>
    </tr>
    @foreach ($items as $key => $item)
    @php
        $product = $item->product;
    @endphp
        <tr>
            <td style="width: 30px">{{$key}}</td>
            <td style="text-align: left">
            <img src="{{$product ? $product->image : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShpS5aS_dPnpUd7EYrG3BddAJc0S-eneFx5w&usqp=CAU'}}" class="img-thumbnail" height="50px" width="50px">
            
                @if ($product)
                    <a href="">{{$item->name}}</a>
                @else
                    {{$item->name}}
                @endif
                
            </td>
            <td style="width: 100px">
                <span class="mb-1"> {{bnConvert()->bnNum($item->quantity)}}</span>
            </td>
            <td style="width: 100px">{{bnConvert()->bnNum($item->price)}} ৳</td>
            <td style="width: 150px">{{bnConvert()->bnNum($item->wholesale_price)}} ৳</td>
            <td style="width: 100px">{{bnConvert()->bnNum($item->profit)}} ৳</td>
            <td style="width: 100px">{{bnConvert()->bnNum($item->total)}} ৳</td>
        </tr>
    @endforeach
        <tr>
            <td colspan="3"></td>
            <td colspan="2">Sub Total</td>
            <td colspan="2">{{$order->subtotal}}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="2">Delivery Fee</td>
            <td colspan="2">{{$order->shipping_total}}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="2">Discount</td>
            <td colspan="2">{{$order->discount_total}}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="2">Total</td>
            <td colspan="2">{{$order->total}}</td>
        </tr>
        
</table>