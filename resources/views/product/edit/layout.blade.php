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
    <form action="{{ route('product.edit.update_general_data', request()->route()->parameters()) }}" method="post"
        data-function="Product.update(form)">
    <div class="row" style="">
        
            @csrf
            <div class="col-md-8" style="margin-top: 10px;">
                <div class="card">
                    <div class="card-header">
                        @yield('product_edit_header')
                    </div>
                    <div class="card-body">
                        @yield('product_edit_content')
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-top: 10px;">
                @yield('meadia_content')
            </div>
        
    </div>
</form>
@stop
