@extends('adminlte::page')

@section('css')
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/fav.png')}}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    @include('layouts.modal')
@stop

@section('js')
    <script src="{{mix('js/app.js')}}"></script>
    @stack('scripts')
@stop