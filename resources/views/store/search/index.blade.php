@extends('store.layout.layout')
@section('content')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css">
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
            padding: 1px;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #dcd9d9;
            box-shadow: 0 -1px 12px hsla(var(--hue), var(--sat), 15%, 0.30);
            margin-bottom: 5px;
        }

        .searchArea input {
            width: 100%;
            border-radius: 5px;
            border: 1px solid #eeeeee;
            border-width: 1px 0px 1px 1px;
            display: block;
            padding: 9px 4px 9px 10px;
            margin: -1px 0px 0px -1px;
            /* background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 5px center; */
        }

        .searchArea input:focus {
            outline: 0px solid #aaaaaa;
            border-color: #c6c6c6;
            
        }

        .searchArea .searchButton {
            border-radius: 5px;
            background: #554594;
            width: 45px;
            border: 0px;
            color: #ffffff;
        }

        .searchArea .form-control:focus {
            box-shadow: 0 0 0 0rem red;
        }
    </style>
    
    <div class="searchArea sticky-top">
        <div class="input-group">
            <input type="search" autocomplete="off" id="search" autofocus value="{{ $searchQuery }}" class="form-control"
                placeholder="পণ্য খুঁজুন (যেমন, ডিম, দুধ, আলু)">
            <div class="input-group-append">
                <button id="searchBtn" onclick="Store.search.searchBtnClick()" class="searchButton" style="" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <div id="suggestionArea"></div>
        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>
    <script>
        $('#search').autoComplete({
            cache: false,
            minChars: 1,
            autoFocus: true,
            source: function(term, response) {
                let productName = $('#search').val();
                $.getJSON('{{ route('product.name_suggestions') }}', {
                    query: productName
                }, function(data) {
                    response(data);
                });
            },
            appendTo: $("#suggestionArea"),
        })
    </script>
@endpush
