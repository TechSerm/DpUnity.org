@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-3">
        @include('product.edit.sidebar')
    </div>
    <div class="col-md-9">
        @include('product.edit.body')
    </div>
</div>

@stop