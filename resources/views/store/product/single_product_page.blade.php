@if (isset($searchQuery))
    <div class="col-md-12">
        <div
            style="text-align: center; margin-right: 10px; color: #A9A9A9; margin-bottom: 20px;padding-bottom: 15px;border-bottom: 1px solid #dbdbdb">
            অনুসন্ধান ফলাফল: <b>"{{ $searchQuery }}"</b><br />
            <div style="font-size: 10px;">
                <b>"{{ $searchQuery }}"</b> এর জন্য <b>{{ bnConvert()->number($totalProducts) }}</b> টি আইটেম পাওয়া
                গেছে
            </div>
        </div>

        @if ($totalProducts == 0)
            <div style="text-align: center; margin-top: 50px">
                <img height="160" width="130" src="{{ asset('assets/img/product_not_found.svg') }}" alt="">
                <h5 style="color: #DE4839; font-weight: bold">আপনার অনুসন্ধান কৃত পণ্যটি পাওয়া যায় নি</h5>
            </div>
        @endif
    </div>
@endif

@foreach ($products as $product)
    @if ($product->category_name != '')
        <div class="col-md-12">
            <div class="home-list-category-name">
                <span class="titleSpan">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    {{ $product->category_name }}
                </span>
            </div>
        </div>
    @endif
    <div class="col-md-2 col-sm-6 col-lg-2 col-6">
        {{-- @include('store.product.single_product', ['product' => $product]) --}}
        @livewire('shop-product', ['product' => $product])
    </div>
@endforeach


{{-- {{$cpage}} --}}

{{-- <button wire:click='barau' class="btn btn-primary">Load More</button> --}}
