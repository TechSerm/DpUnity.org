<link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css">
<div class="">
    <div class="mb-3 row ">
        <label for="name" class="col-md-2 col-form-label form-control-label">পণ্যের আইডি</label>
        <div class="col-md-2">
            <input type="text" class="form-control" name="name" id="filter_product_id" value="">
        </div>
        <label for="product_name" class="col-md-2 col-form-label form-control-label">পণ্যের নাম</label>
        <div class="col-md-2">
            <input type="text" class="form-control" name="filter_product_name" id="product_name" value="">
        </div>
        <label for="name" class="col-md-2 col-form-label form-control-label">ক্যাটাগরি</label>
        <div class="col-md-2">
            <select name="category" id="filter_category" class="form-control">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3 row" style="margin-top: -2px">
        @if (auth()->user()->isAdmin())
        <label for="name" class="col-md-2 col-form-label form-control-label">দোকান</label>
        <div class="col-md-2">
            <select name="vendor" id="filter_vendor" class="form-control">
                <option value="">All Vendor</option>
                @foreach ($vendors as $vendor)
                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                @endforeach
            </select>
        </div>
        @endif
        <label for="name" class="col-md-2 col-form-label form-control-label">স্টক</label>
        <div class="col-md-2">
            <select name="" id="filter_has_stock" class="form-control">
                <option value="">Any</option>
                <option value="yes">আছে</option>
                <option value="no">নেই</option>
            </select>
        </div>
        <label for="name" class="col-md-2 col-form-label form-control-label">অবস্থা</label>
        <div class="col-md-2">
            <select name="status" id="filter_status" class="form-control">
                <option value="">Any</option>
                <option value="publish">Publish</option>
                <option value="private">Private</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 offset-md-9">
            <div style="margin: 5px 0px 0px 0px;text-align: right">
                <button type="submit" class="btn btn-primary mr-1" onclick="productTableFilter()"><i class="fa fa-filter" aria-hidden="true"></i>
                    Filter</button>
                <button type="reset" class="btn btn-warning mr-1"><i class="fa fa-refresh"></i> Reset</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>
    <script>
        $('#product_name').autoComplete({
            cache: false,
            minChars: 1,
            source: function(term, response) {
                let productName = $('#product_name').val();
                $.getJSON('{{ route('product.name_suggestions') }}', {
                    query: productName
                }, function(data) {
                    response(data);
                });
            }
        });
    </script>
@endpush
