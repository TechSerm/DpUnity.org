@extends('layouts.app')
@section('title', 'Product Report')
@section('content_header')
    <h1>Product Report</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">Filter</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="label mb-2">
                        <b>To Date</b>
                    </div>
                    <input type="date" value="{{request()->start_date}}" id="startDate" class="form-control">
                </div>
                <div class="col-md-3">
                    <div class="label mb-2">
                        <b>Form Date</b>
                    </div>
                    <input type="date" value="{{request()->end_date}}" id="endDate" class="form-control">
                </div>
                <div class="col-md-3">
                    <div class="label mb-2">
                        <b> Category</b>
                    </div>
                    <select name="" id="categorySelect" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{request()->category == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="label">

                    </div>
                    <button class="btn btn-primary" style="margin-top: 30px;" onclick="filterProductReport()">Filter</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Product List</div>
        <div class="card-body">
            <table class="table table-bordered mb-2">
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Product Name</th>
                    <th style="width: 130px;">Sold</th>
                </tr>
                @php
                    $page = request()->page ? request()->page : 1;
                    $page -= 1;
                @endphp
                @foreach ($products as $key => $product)
                    <tr>
                        <td style="width: 15px;">{{ $page * 10 + $key + 1 }}</td>
                        <td><a href="{{ route('products.show', $product->product) }}" data-toggle="modal"
                                data-modal-header="{{ $product->product->id . ' - ' . $product->product->name }}"
                                data-modal-size="md">{{ $product->product->name }}</a></td>
                        <td style="width: 150px;">{{ $product->total_amount_sold }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="float-right">
                {{ $products->render(null, request()->all()) }}
            </div>
            
        </div>
    </div>

@stop

@push("scripts")
<script>
    function filterProductReport() {
        startDate = $("#startDate").val();
        endDate = $("#endDate").val();
        categoryId = $("#categorySelect").val();
        
        var url = new URL(window.location.href);
        url = url.origin + url.pathname;
        url = new URL(url);
        url.searchParams.set('start_date', startDate);
        url.searchParams.set('end_date', endDate);
        url.searchParams.set('category', categoryId);

        window.location.href = url;
    }
</script>
@endpush
