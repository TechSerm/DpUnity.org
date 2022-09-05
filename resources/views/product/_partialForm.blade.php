@php
$labelWidth = 4;
$inputWidth = 6;
@endphp


<div class="mb-3 row ">
    <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Product Name</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('name', null, ['class' => 'form-control ', 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="wholesale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Wholesale
        Price</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('wholesale_price', null, ['class' => 'form-control ', 'id' => 'wholesale_price']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="market_sale_price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Market Sale
        Price</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('market_sale_price', null, ['class' => 'form-control ', 'id' => 'market_sale_price']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="profit" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Profit</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('profit', null, ['class' => 'form-control ', 'id' => 'profit']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="price" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Price</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('price', null, ['class' => 'form-control ', 'id' => 'price']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="status" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Status</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::select('status', ['private' => 'Private', 'publish' => 'Publish'], null, ['placeholder' => 'Select Status','class' => 'form-control ', 'id' => 'status']); !!}
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
                <option value="{{$category->id}}" selected>{{$category->name}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3 row">
    <label for="image" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"
        for="image">Image</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::file('image', null, ['class' => 'form-control ', 'id' => 'image']) !!}
        <img src="{{ isset($product) ? $product->image : 'https://catalogue.bticino.com/app/webroot/img/img_not_found_prod_it.jpg' }}"
            id="image-preview" height="180px" width="180px" class="img-thumbnail mt-2" alt="">
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
</script>
