@extends('layouts.app')
@section('title', 'Sliders')
@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header">
                    Add Slider
                </div>
                <div class="card-body">
                    @include('slider.create')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-header">
                    Preview Slider
                </div>
                <div class="card-body">
                    @include('slider.preview')
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Slider List
                </div>
                <div class="card-body">
                    @include('slider.list')
                </div>
            </div>
        </div>
    </div>

@endsection
