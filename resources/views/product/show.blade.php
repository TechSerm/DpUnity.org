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

@php
$isVendor = auth()
        ->user()
        ->isVendor();
    $displayNone = $isVendor ? 'display: none': '';
    
@endphp

<div class="mb-3 row ">
    <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পণ্যের নাম</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('name', $product->name, ['class' => 'form-control ', 'id' => 'name', 'readonly' => true]) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="quantity" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পরিমান</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('quantity', bnConvert()->number($product->quantity)." ".bnConvert()->unit($product->unit), ['class' => 'form-control ', 'id' => 'quantity', 'step' => '0.01', 'readonly' => true]) !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="wholesale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পাইকারি
        মূল্য</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('wholesale_price', $product->wholesale_price, ['class' => 'form-control ', 'id' => 'wholesale_price', 'readonly' => true]) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="market_sale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">বাজার দর</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('market_sale_price', $product->market_sale_price, ['class' => 'form-control ', 'id' => 'market_sale_price', 'readonly' => true]) !!}
    </div>
</div>
<div style="{{ $displayNone }}">
    <div class="mb-3 row">
        <label for="profit" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">লাভ</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::number('profit', $product->profit, ['class' => 'form-control ', 'id' => 'profit', 'readonly' => true]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">বিবিসিনা
            মূল্য</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::number('price', $product->price, ['class' => 'form-control ', 'id' => 'price', 'readonly' => true]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="delivery_fee" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">ডেলিভারি
            ফী</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::number('delivery_fee', $product->delivery_fee, ['class' => 'form-control ', 'id' => 'delivery_fee', 'readonly' => true]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="status" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">অবস্থা</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::text('name', bnConvert()->unit($product->status), ['class' => 'form-control ', 'id' => 'name', 'readonly' => true]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="categories" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"
            for="image">ক্যাটাগরি</label>
        <div class="col-sm-{{ $inputWidth }}" style="padding-top: 5px;">
                @php
                    $categories = isset($product) ? $product->categories : [];
                @endphp
                @foreach ($categories as $category)
                    <span class="badge badge-secondary">{{ $category->name }}</span>
                @endforeach

        </div>
    </div>
</div>

<div class="mb-3 row">
    <label for="image1" class="col-sm-{{ $labelWidth }} col-form-label form-control-label" for="image">পণ্যের
        ছবি</label>
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
