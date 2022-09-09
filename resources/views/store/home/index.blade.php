
@section('content')

    <style>
        .loader-area {
            display: none;
            text-align: center;
        }
    </style>

    <div class="row" id="product-list">

        @livewire('shop-products')

    </div>
    <div class="loader-area" id="loader-area">
        <img src="https://i.gifer.com/origin/b4/b4d657e7ef262b88eb5f7ac021edda87.gif" alt="">
    </div>
    
@stop

@push('scripts')
    <script>
        
        $(document.body).on('touchmove', onScroll); // for mobile
        $(window).on('scroll', onScroll);

        function onScroll() {
            if ($(window).scrollTop() + window.innerHeight + 10 >= document.body.scrollHeight) {
                Store.home.loadHomeProduct("{{ route('store.home.products') }}");
            }
        }
    </script>
@endpush

