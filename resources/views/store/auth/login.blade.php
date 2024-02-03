@extends('store.layout.layout')

@section('content')


    <style>
        .form-control-label {
            text-align: right;
            font-weight: bold;
        }

        @media screen and (max-width: 767px) {
            .form-control-label {
                text-align: left;
            }
        }

    </style>
    <div class="row">
        <div class="col-md-3">
            
        </div>
        <div class="col-md-6">
            <div class="store-card mt-5">
                <div class="header text-center" style="">
                    Login Your Account
                </div>
                <div class="body">
                    <form action="{{ route('login') }}" data-function="Store.auth.login(form)" class="form" method="post">
                        @csrf
                        <div class="mb-3 row ">
                            <label for="email" class="col-sm-4 col-form-label form-control-label">Email</label>
                            <div class="col-sm-6">
                                <input class="form-control " id="email" name="email" type="email">
                            </div>
                        </div>
                        <div class="mb-3 row ">
                            <label for="password" class="col-sm-4 col-form-label form-control-label">Password</label>
                            <div class="col-sm-6">
                                <input class="form-control " id="password" name="password" type="password">
                            </div>
                        </div>
                        <div class="mb-3 row ">
                            <label for="quantity" class="col-sm-4 col-form-label form-control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary">Login</button> <div class="mt-2"> Don't have an account? <a href=""><b>Register</b></a> </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@stop
