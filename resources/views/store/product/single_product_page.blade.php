
@foreach ($products as $product)
    <div class="col-md-2 col-sm-6 col-lg-2 col-6">
        {{-- @include('store.product.single_product', ['product' => $product]) --}}
        @livewire('shop-product', ['product' => $product])
    </div>    
@endforeach


{{-- {{$cpage}} --}}

{{-- <button wire:click='barau' class="btn btn-primary">Load More</button> --}}