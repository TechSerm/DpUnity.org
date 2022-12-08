@extends('layouts.app')
@section('content_header')
    <h1>Home Page Product</h1>
@stop
@section('content')

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tbody id="homeProductTable">
                @foreach ($products as $product)
                    <tr>
                        <td><img src="{{ $product->product->image }}" alt="" height="80px" width="80px"> </td>
                        <td>{{ $product->product->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection

@push("scripts")
    <script>
        $('#homeProductTable').sortable();
    </script>
@endpush
