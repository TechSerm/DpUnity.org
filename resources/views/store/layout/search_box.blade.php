<style>
    .loader-area {
        display: none;
        text-align: center;
    }

    .searchBoxArea {
        
        text-align: center;
        background: #ffffff;
        padding: 1px;
        text-align: center;
        border-radius: 5px;
        width: 100%;
        border: 1px solid #dcd9d9;
    }

    .searchBoxArea input {
        width: 100%;
        border-radius: 5px;
        height: 44px;
        border: 1px solid #eeeeee;
        border-width: 1px 0px 1px 1px;
        display: block;
        padding: 10px 4px 10px 10px;
        margin: -1px 0px 0px -1px;
        /* background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 5px center; */
    }

    .searchBoxArea input:focus {
        outline: 0px solid #aaaaaa;
        border-color: #c6c6c6;

    }

    .searchBoxArea .searchButton {
        border-radius: 5px;

        width: 35px;
        border: 0px;
        color: #554594;
    }

    .searchBoxArea .form-control:focus {
        box-shadow: 0 0 0 0rem red;
    }

    .loginBtn {
        border-radius: 5px;
        border: 1px solid #c6c6c6;
        width: 35px;
        color: #554594;
        margin-left: 5px;
    }

    #suggestionArea {
        display: block;
        background: #000000;
        position: relative
    }

    .ui-autocomplete {
        position: absolute;
    }
</style>
<div class="nav__menu mt-1" style="float: right; " id="nav-menu">
    <ul class="nav__list" style="margin-top: -4px">
        <div class="searchBoxArea" >
            <div class="input-group">
                <input type="search" autocomplete="off" id="search" value="{{ request()->q }}" class="form-control"
                    placeholder="পণ্য খুঁজুন (যেমন, ডিম, দুধ, আলু)">
                <div class="input-group-append">
                    <button id="searchBtn" onclick="Store.search.searchProduct()" class="searchButton" style=""
                        type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <div id="suggestionArea"></div>
            </div>
        </div>
        <button class="loginBtn" onclick="Store.menu.goNewPage('admin')">
            <i class="fa fa-sign-in" aria-hidden="true"></i>
        </button>
    </ul>
</div>


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#search').keypress(function(event) {
                if (event.keyCode === 13) {
                    Store.search.searchProduct();
                }
            });
        });

        Store.search.init({
            searchUrl: "{{ route('search.products') }}",
            searchResultUrl: "{{ route('search') }}",
            searchQuery: "{{ request()->q }}"
        });

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
            onSelect: function(event, ui) {
                Store.search.searchProduct();
            },
            appendTo: $("#suggestionArea"),
        });
    </script>
@endpush
