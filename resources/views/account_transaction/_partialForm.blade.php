@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp


<div class="mb-3 row ">
    <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">টাকার পরিমান</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::number('amount', null , ['class' => "form-control ", 'id' => 'amount']) !!}
    </div>
</div>
<div class="mb-3 row ">
    <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">নোট</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::textarea('note', null , ['class' => "form-control ", 'id' => 'note']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{$labelWidth}} col-form-label form-control-label"></label>
    <div class="col-sm-{{$inputWidth}}">
        <button type="submit" class="btn btn-success">{{$submitButtomText}}</button>
    </div>
</div>




