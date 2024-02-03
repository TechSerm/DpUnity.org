@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp


<div class="mb-3 row ">
    <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Brand Name</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('name', null , ['class' => "form-control ", 'id' => 'name']) !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="image" class="col-sm-{{$labelWidth}} col-form-label form-control-label" for="image">Image</label>
    <div class="col-sm-{{$inputWidth}}">
        <input type="file" name="image" id="image" onchange="previewFile(event)">
        <img src="{{ isset($brand) ? $brand->image : url('images/default.png') }}" id="image-preview" height="180px" width="180px" class="img-thumbnail mt-2" alt="">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{$labelWidth}} col-form-label form-control-label"></label>
    <div class="col-sm-{{$inputWidth}}">
        <button type="submit" class="btn btn-success">Save Brand</button>
    </div>
</div>




