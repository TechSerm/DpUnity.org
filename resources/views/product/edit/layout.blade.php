@extends('layouts.app')
@section('content')

    <style>
        .form-control-label {
            margin-top: -2px;
        }

        fieldset {
            background-color: #f9f9f9;
            border: 1px solid #eeeeee;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        legend {
            background-color: gray;
            color: white;
            width: 180px;
            font-size: 15px;
            padding: 2px;
            margin-left: 15px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
    <div class="row" style="">
        <div class="col-md-3" style="margin-top: 10px;">
            @include('product.edit.sidebar')
        </div>
        <div class="col-md-9" style="margin-top: 10px;">
            <div class="card">
                <div class="card-header">
                    @yield('product_edit_header')
                </div>
                <div class="card-body">
                    @yield('product_edit_content')
                </div>
            </div>
        </div>
    </div>

@stop
