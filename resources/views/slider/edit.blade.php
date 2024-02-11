{{ Form::model($slider, ['method' => 'PATCH','route' => ['sliders.update', request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}

@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp


<div class="mb-3 row ">
    <label for="title" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Title</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('title', null , ['class' => "form-control ", 'id' => 'title']) !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="image" class="col-sm-{{$labelWidth}} col-form-label form-control-label" for="image">Image</label>
    <div class="col-sm-{{$inputWidth}}">
        <input type="file" name="image" id="image" onchange="previewFile(event)">
        <img src="{{ isset($slider) ? $slider->image : url('images/default.png') }}" id="image-preview" height="180px" width="180px" class="img-thumbnail mt-2" alt="">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{$labelWidth}} col-form-label form-control-label"></label>
    <div class="col-sm-{{$inputWidth}}">
        <button type="submit" class="btn btn-success">Update Slider</button>
    </div>
</div>

{!! Form::close() !!}