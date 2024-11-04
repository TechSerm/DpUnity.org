<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

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
        $transactions = null;
        if(auth()->user()->member()) {
            $transactions = Transaction::diposite()->where('member_id', auth()->user()->member()->id)->get();
        }
        
        return view('profile.index', compact('transactions'));
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

    public function diposite()
    {
        $transactions = Transaction::diposite()->with('member')->get();
        return view('diposite.index', compact('transactions'));
    }
}
