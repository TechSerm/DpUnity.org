@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp


<div class="mb-3 row ">
    <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Category Name</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('name', null , ['class' => "form-control ", 'id' => 'name']) !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="image" class="col-sm-{{$labelWidth}} col-form-label form-control-label" for="image">Image</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::file('image', null, ['class' => 'form-control ', 'id' => 'image']) !!}
        <img src="{{ isset($category) ? $category->image : 'https://catalogue.bticino.com/app/webroot/img/img_not_found_prod_it.jpg' }}" id="image-preview" height="180px" width="180px" class="img-thumbnail mt-2" alt="">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{$labelWidth}} col-form-label form-control-label"></label>
    <div class="col-sm-{{$inputWidth}}">
        <button type="submit" class="btn btn-success">Save Category</button>
    </div>
</div>




