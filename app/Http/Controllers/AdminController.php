<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $admin = Admin::all();
        return view('admin.index', [
            'admin' => $admin
        ]);
    }

    public function show(){

    }

    public function store(){

    }
}
