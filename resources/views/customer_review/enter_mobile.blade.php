{!! Form::open(['route' => ['customer_reviews.enter_mobile'], 'data-page-reload' => 'false' , 'data-modal-close' => 'false', 'data-load-modal-with-response' => 'true' , 'files' => true, 'class' => 'form-horizontal']) !!}

@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp

<div class="mb-3 row ">
    <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Customer Mobile</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::number('mobile', '01777564786' , ['class' => "form-control ", 'id' => 'mobile']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{$labelWidth}} col-form-label form-control-label"></label>
    <div class="col-sm-{{$inputWidth}}">
        <button type="submit" class="btn btn-success">Next</button>
    </div>
</div>

{!! Form::close() !!}