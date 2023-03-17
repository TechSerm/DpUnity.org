<div class="">
    <div class="mb-3 row ">
        <label for="name" class="col-md-2 col-form-label form-control-label">পণ্যের আইডি</label>
        <div class="col-md-2">
            <input type="text" class="form-control" name="name" id="product_id" value="">
        </div>
        <label for="product_name" class="col-md-2 col-form-label form-control-label">পণ্যের নাম</label>
        <div class="col-md-2">
            <input type="text" class="form-control" name="product_name" id="product_name" value="">
        </div>
        <label for="name" class="col-md-2 col-form-label form-control-label">ক্যাটাগরি</label>
        <div class="col-md-2">
            <select name="" id="" class="form-control">
                <option value="">Hello</option>
            </select>
        </div>
    </div>

    <div class="mb-3 row" style="margin-top: -2px">
        <label for="name" class="col-md-2 col-form-label form-control-label">দোকান</label>
        <div class="col-md-2">
            <select name="" id="" class="form-control">
                <option value="">Hello</option>
            </select>
        </div>
        <label for="name" class="col-md-2 col-form-label form-control-label">স্টক</label>
        <div class="col-md-2">
            <select name="" id="" class="form-control">
                <option value="">Hello</option>
            </select>
        </div>
        <label for="name" class="col-md-2 col-form-label form-control-label">অবস্থা</label>
        <div class="col-md-2">
            <select name="" id="" class="form-control">
                <option value="">Hello</option>
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
