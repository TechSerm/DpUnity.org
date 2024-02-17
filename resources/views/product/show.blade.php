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
</style>



<div class="mb-3 row ">
    <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Product Name</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('name', $product->name, ['class' => 'form-control ', 'id' => 'name', 'readonly' => true]) !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="market_sale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Regular
        Price</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('regular Price', $product->regular_price, [
            'class' => 'form-control ',
            'id' => 'market_sale_price',
            'readonly' => true,
        ]) !!}
    </div>
</div>
<div class="mb-3 row">
    <label for="profit" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Sale Price</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('sale_price', $product->sale_price, [
            'class' => 'form-control ',
            'id' => 'profit',
            'readonly' => true,
        ]) !!}
    </div>
</div>



<div class="mb-3 row">
    <label for="categories" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"
        for="image">Categories</label>
    <div class="col-sm-{{ $inputWidth }}" style="padding-top: 5px;">
        @php
            $categories = isset($product) ? $product->categories : [];
        @endphp
        @foreach ($categories as $category)
            <span class="badge badge-secondary">{{ $category->name }}</span>
        @endforeach

    </div>
</div>


<div class="mb-3 row">
    <label for="image1" class="col-sm-{{ $labelWidth }} col-form-label form-control-label" for="image">Image</label>
    <div class="col-sm-{{ $inputWidth }}">
        <img src="{{ isset($product) ? $product->image : url('images/default.png') }}" id="image-preview"
            height="180px" width="180px" class="img-thumbnail mt-2" alt="">
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
