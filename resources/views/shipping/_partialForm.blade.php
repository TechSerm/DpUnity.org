@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp

<div class="mb-3 row ">
    <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Shipping Name</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('name', null , ['class' => "form-control ", 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="unit" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">একক</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::select('unit', $units, null, ['placeholder' => 'Select Status','class' => 'form-control ', 'id' => 'status']); !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="cost" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Cost</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::number('cost', null , ['class' => "form-control ", 'id' => 'cost']) !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{$labelWidth}} col-form-label form-control-label"></label>
    <div class="col-sm-{{$inputWidth}}">
        <button type="submit" class="btn btn-success">Save Category</button>
    </div>
</div>

