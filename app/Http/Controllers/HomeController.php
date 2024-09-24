<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', []);
    }

    public function profile()
    {
        return view('profile.index');
    }

    public function memberForm()
    {
        return view('member.form');
    }

    public function members()
    {
        return view('member.list');
    }

    public function aboutUs()
    {
        return view('about_us');
    }
}
