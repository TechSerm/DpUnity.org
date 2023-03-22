{!! Form::open(['route' => ['delivery_transport_costs.store'], 'files' => true, 'class' => 'form-horizontal']) !!}

@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp


<div class="mb-3 row ">
    <label for="amount" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পরিমান (টাকা)</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::number('amount', null, ['class' => 'form-control ', 'id' => 'amount']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="note" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">নোট</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::textarea('note', null, ['class' => 'form-control ', 'id' => 'note']) !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">ডেলিভারি খরচ যুক্ত করুন</button>
    </div>
</div>

{!! Form::close() !!}
