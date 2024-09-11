@extends('admin.layout')
@section('title', 'Dashboard')
@section('content_header')
    <h1>Dashboard</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <a href="" class="btn btn-primary" onclick="event.preventDefault(); this.closest('form').submit();">
            Logout
        </a>
    </form>
@stop


@section('content')

welcome to admin panel

@endsection
