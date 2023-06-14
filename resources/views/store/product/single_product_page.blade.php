@foreach ($products as $product)
    @if ($product->category_name != '')
        <div class="col-md-12">
            <div class="home-list-category-name"><i class="fa fa-arrow-right" aria-hidden="true"></i> {{ $product->category_name }}</div>
        </div>
    @endif
    <div class="col-md-2 col-sm-6 col-lg-2 col-6">
        {{-- @include('store.product.single_product', ['product' => $product]) --}}
        @livewire('shop-product', ['product' => $product])
    </div>
@endforeach


{{-- {{$cpage}} --}}

{{-- <button wire:click='barau' class="btn btn-primary">Load More</button> --}}
