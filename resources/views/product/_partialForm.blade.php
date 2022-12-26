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
        {!! Form::text('name', null, ['class' => 'form-control ', 'id' => 'name', 'readonly' => $isVendor]) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="quantity" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পরিমান</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('quantity', null, ['class' => 'form-control ', 'id' => 'quantity', 'step' => '0.01', 'readonly' => $isVendor]) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="unit" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">একক</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::select('unit', $units, null, [
            'placeholder' => 'Select Unit',
            'class' => 'form-control ',
            'id' => 'status',
            'disabled' => $isVendor
        ]) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="wholesale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পাইকারি
        মূল্য</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('wholesale_price', null, ['class' => 'form-control ', 'id' => 'wholesale_price']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="market_sale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">বাজার দর</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('market_sale_price', null, ['class' => 'form-control ', 'id' => 'market_sale_price']) !!}
    </div>
</div>
<div style="{{ $displayNone }}">
    <div class="mb-3 row">
        <label for="profit" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">লাভ</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::number('profit', null, ['class' => 'form-control ', 'id' => 'profit']) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">বিবিসিনা
            মূল্য</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::number('price', null, ['class' => 'form-control ', 'id' => 'price']) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="delivery_fee" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">ডেলিভারি
            ফী</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::number('delivery_fee', null, ['class' => 'form-control ', 'id' => 'delivery_fee']) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="status" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">অবস্থা</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::select('status', ['private' => 'Private', 'publish' => 'Publish'], null, [
                'placeholder' => 'Select Status',
                'class' => 'form-control ',
                'id' => 'status',
            ]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="categories" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"
            for="image">ক্যাটাগরি</label>
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
</div>

<div class="mb-3 row">
    <label for="image1" class="col-sm-{{ $labelWidth }} col-form-label form-control-label" for="image">পণ্যের
        ছবি</label>
    <div class="col-sm-{{ $inputWidth }}">
        <div style="{{$displayNone}}">
            <input type="file" name="image" id="image" onchange="previewFile(event)">
        </div>
        <img src="{{ isset($product) ? $product->image : url('images/default.png') }}" id="image-preview"
            height="180px" width="180px" class="img-thumbnail mt-2" alt="">
    </div>
</div>


<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">Save Product</button>
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
