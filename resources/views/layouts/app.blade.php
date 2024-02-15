@extends('adminlte::page')

@section('css')
    <link rel="icon" type="image/x-icon" href="{{ theme()->favicon() }}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <script src="{{ asset('lib/ckeditor/4.13.1/ckeditor.js') }}"></script>
    @include('layouts.modal')
@stop

@section('js')
    <script src="{{mix('js/app.js')}}"></script>
    @stack('scripts')
@stop