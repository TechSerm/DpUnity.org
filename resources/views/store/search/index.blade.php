@extends('store.layout.layout')
@section('content')

    <style>
        .loader-area {
            display: none;
            text-align: center;
        }

        .searchArea {
            top: 60px;
            z-index: 1500;
            text-align: center;
            background: #ffffff;
            padding: 5px;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0 -1px 12px hsla(var(--hue), var(--sat), 15%, 0.15);
            margin-bottom: 5px;
        }

        .searchArea input {
            width: 100%;
            border-radius: 5px;
            border: 1px solid #aaaaaa;
            display: block;
            padding: 9px 4px 9px 40px;
            background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 13px center;
        }

        .searchArea input:focus {
            outline: 1px solid #aaaaaa;
        }
    </style>
    <div class="searchArea sticky-top">
        <input type="text" id="search" value="{{ $searchQuery }}" placeholder="পণ্য খুঁজুন (যেমন, ডিম, দুধ, আলু)"
            autofocus>
    </div>
    <div class="row no-gutters" style="margin: 15px -15px 0px -5px;" id="searchResultProductList">
        @include('store.product.single_product_page', ['products' => $products])
    </div>
    <div class="loader-area" id="search-loader-area">
        <img src="{{ asset('assets/img/loader.gif') }}" height="70px" width="70px" alt="">
    </div>

@stop

@push('scripts')
    <script>
        Store.search.init({
            searchUrl: "{{ route('search.products') }}",
            searchQuery: "{{ $searchQuery }}"
        });
    </script>
@endpush
