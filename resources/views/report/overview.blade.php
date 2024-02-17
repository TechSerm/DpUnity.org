@extends('layouts.app')
@section('title', 'Overview Report')
@section('content_header')
    <h1>Overview Report</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header"><b>Product Snapshot</b></div>
    <div class="card-body">
        @include('dashboard.product_area')
    </div>
</div>

<div class="card">
    <div class="card-header"><b>Order Snapshot</b></div>
    <div class="card-body">
        @include('dashboard.order_area')
    </div>
</div>

@stop