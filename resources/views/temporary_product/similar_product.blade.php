
    <div class="">
        <div class="card-header bg-warning" style="font-weight:bold">
            এই পণ্যটির সাথে {{ bnConvert()->number(count($similarProducts)) }} টি পণ্যের মিল পাওয়া যাচ্ছে!
        </div>
        <div style="max-height: 300px;overflow-y:scroll;">
            <table class="table table-bordered" style="">
                <tr>
                    <td>পণ্যের ছবি</td>
                    <td>পণ্য</td>
                </tr>
                @foreach ($similarProducts as $product)
                    <tr>
                        <td> <img src="{{ $product->image }}" height="50px" width="50px" alt=""> </td>
                        <td style="text-align: left">
                            <div style="font-size: 11px; font-weight: bold">
                                <a data-toggle="modal" data-modal-size="md"
                                        data-modal-header="Product #{{ $product->id }}"
                                        href="{{ route('products.show', ['product' => $product->id]) }}">{{ $product->id }} - {{ $product->name }}</a>
                                
                            </div>
                            <div style="font-size: 13px;font-weight: bold; color: #767575; ">
    
                                {{ bnConvert()->number($product->quantity, false) }}
                                {{ bnConvert()->unit($product->unit) }} 
                                @if ($product->vendor)
                                    <span class="badge"
                                        style="background-color: {{ $product->vendor->color }}; color: #ffffff">{{ $product->vendor->name }}</span>
                                @endif
                                <br/>
                                <span class="badge badge-warning">পাইকারি: {{ bnConvert()->number($product->wholesale_price) }} ৳</span> <span class="badge badge-info"> বাজার দর: {{ bnConvert()->number($product->market_sale_price) }} ৳</span> <span class="badge badge-success"> লাভ: {{ bnConvert()->number($product->profit) }} ৳</span>
                                <br/>
                                <span class="badge badge-secondary">যুক্ত হয়েছে: {{ bnConvert()->date($product->created_at->diffForhumans()) }}</span>
                                <span class="badge badge-primary">আপডেট  হয়েছে: {{ bnConvert()->date($product->updated_at->diffForhumans()) }}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

