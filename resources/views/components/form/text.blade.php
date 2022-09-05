@extends('components.form.layout')

@section('type')

@php
    $options = [];
@endphp

{!! Form::text($name, $value, $options) !!}
@endsection
