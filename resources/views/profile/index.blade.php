@extends('store.layout.layout')
@section('title', theme()->title() . ' - ' . theme()->slogan())
@section('content')

    <div class="container">
        <div class="main-body">


            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('images/default.png') }}" alt="Admin" class="img-thumbnail"
                                    width="150">
                                <div class="mt-3">
                                    <h4>{{ auth()->user()->name }}</h4>
                                    <p class="text-secondary mb-1">{{ auth()->user()->phone }}</p>
                                    <p class="text-muted font-size-sm">{{ auth()->user()->email }}</p>
                                    
                                    {{-- <button class="btn btn-primary mt-2" style="width: 100%"> <i class="fa fa-edit"></i> Edit Info</button>
                                    <button class="btn btn-warning mt-2" style="width: 100%"><i class="fas fa-key"></i> Change Password</button> --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="" class="btn btn-danger mt-2" style="width: 100%"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a>
                                    </form>
                                    @if (auth()->user()->isAdmin())
                                    <a href="{{route('admin.home.index')}}" class="btn btn-success mt-2" style="width: 100%"><i class="fas fa-tachometer-alt"></i> Go Admin
                                        Panel</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ auth()->user()->name }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ auth()->user()->phone }}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@stop
