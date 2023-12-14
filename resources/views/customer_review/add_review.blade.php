<style>
    .customer_review_field_box {
        height: auto;
        width: 100%;
        margin-top: 30px;
        border: 1px solid #aaaaaa;
        border-radius: 5px;
        position: relative;
        padding: 20px 10px 0px 10px;
        font-size: 14px
    }

    .customer_review_field_label {
        position: absolute;
        top: -15px;
        left: 10px;
        font-size: 14px;
        height: 30px;
        padding-top: 5px;
        width: 150px;
        border-radius: 5px;
        background-color: #eeeeee;
        font-weight: bold;
        border: 1px solid  #aaaaaa;
        text-align: center;
    }
</style>

@php
    $labelWidth = 4;
    $inputWidth = 8;
@endphp

{!! Form::open(['route' => route('customer_reviews.add_review', request()->route()->parameters()), 'files' => true, 'class' => 'form-horizontal']) !!}

<div class="customer_review_field_box">
    <div class="customer_review_field_label">Customer Info</div>
    <table class="table table-bordered mt-1">
        <tr>
            <td class="" style="width: 170px;"><b>Customer Name</b></td>
            <td class="">{{$customer->name}}</td>
        </tr>
        <tr>
            <td class=""><b>Customer Mobile</b></td>
            <td class="">{{$customer->mobile}}</td>
        </tr>
        <tr>
            <td class=""><b>Customer Address</b></td>
            <td class="">{{$customer->address}}</td>
        </tr>
    </table>
</div>

<div class="customer_review_field_box">
    <div class="customer_review_field_label">Add Review</div>
    
    <div class="mb-3 row">
        <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Audio</label>
        <div class="col-sm-{{$inputWidth}}">
            {!! Form::datetimelocal('schedule_time', null , ['class' => "form-control ", 'id' => 'schedule_time']) !!}
        </div>
    </div>
    <div class="mb-3 row">
        <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Review Description</label>
        <div class="col-sm-{{$inputWidth}}">
            {!! Form::textarea('schedule_note', $mobile??null , ['class' => "form-control ", 'rows' => 3, 'style' => 'resize:none', 'id' => 'schedule_note']) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-{{$labelWidth}} col-form-label form-control-label"></label>
        <div class="col-sm-{{$inputWidth}}">
            <button type="submit" class="btn btn-success">Add Review</button>
        </div>
    </div>
</div>

{!! Form::close() !!}