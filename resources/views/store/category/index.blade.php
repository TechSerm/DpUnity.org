@extends('store.layout.layout')

@section('content')
<div class="home-listt" style="">
    <div class="home-list-headerr" style=" color: #000000; margin-top: 10px">
        <h4>ক্যাটেগরি</h4>
        <hr>
    </div>
    <div style="margin-right: -12px;">
        @include('store.category.ui')
    </div>
</div>

@stop
