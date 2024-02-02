@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp
<style>
    .select2-selection__choice__display {
        color: black;
        text-align: center;
        margin-left: 5px;
        padding: 5px 5px 3px 5px !important;
    }

    .select2-search__field {
        padding: 0px !important;
        border: 0px solid green !important;
        border-radius: 0px;
    }

    .form-control-label{
        margin-top: -2px;
    }
</style>

@php
    $isVendor = auth()
        ->user()
        ->isVendor();
    $displayNone = $isVendor ? 'display: none' : '';

@endphp

<div class="mb-3 row ">
    <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Product Name</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('name', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="regular_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Regular
        Price</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('regular_price', null, ['class' => 'form-control ', 'id' => 'regular_price']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="sale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Sale
        Price</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('sale_price', null, ['class' => 'form-control ', 'id' => 'sale_price']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="has_hot_deals" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Hot Deals</label>
    <div class="col-sm-{{ $inputWidth }}">
        <label class='switch'>
            <input type='checkbox' name="has_hot_deals">
            <span class='slider round'></span>
        </label>
    </div>
</div>

<div class="mb-3 row">
    <label for="status" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Status</label>
    <div class="col-sm-{{ $inputWidth }}">
        <label class='switch'>
            <input type='checkbox' name="status" checked>
            <span class='slider round'></span>
        </label>
    </div>
</div>


<div class="mb-3 row">
    <label for="categories" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"
        for="image">Categories</label>
    <div class="col-sm-{{ $inputWidth }}">
        <select class="form-control" id="categories" name="categories[]" multiple="multiple">
            @php
                $categories = isset($product) ? $product->categories : [];
            @endphp
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>



<div class="mb-3 row">
    <label for="image1" class="col-sm-{{ $labelWidth }} col-form-label form-control-label" for="image">Product Image</label>
    <div class="col-sm-{{ $inputWidth }}">
        <div style="">
            <input type="file" name="image" id="image" onchange="previewFile(event)">
        </div>
        <img src="{{ isset($product) ? $product->image : url('images/default.png') }}" id="image-preview"
            height="180px" width="180px" class="img-thumbnail mt-2" alt="">
    </div>
</div>


<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">Create New Product</button>
    </div>
</div>


<script>
    $('#categories').select2({
        dropdownParent: Helper.currentModal().body,
        placeholder: 'Select an Categories',
        allowClear: true,
        ajax: {
            url: "{{ route('categories.select2_data') }}",
            dataType: 'json',
            delay: 250,
            processResults: function(response) {
                return {
                    results: $.map(response, function(category) {
                        return {
                            text: category.name,
                            id: category.id,
                        }
                    })
                };
            },
            cache: true
        }
    });

    $("#keywords").select2({
        tags: true,
        tokenSeparators: []
    })
</script>
