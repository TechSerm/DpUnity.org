@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    @include('layouts.modal')
@stop

@section('js')
    <script src="{{mix('js/app.js')}}"></script>
    @stack('scripts')
@stop