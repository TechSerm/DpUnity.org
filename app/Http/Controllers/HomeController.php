<?php

namespace App\Http\Controllers;

use App\Services\File\FileService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

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
        return view('home');
    }

    public function log(){
        Log::info([
            'time' => Carbon::now()->format('M d Y H:i:s'),
            'ip' => request()->ip(),
            'agent' => request()->header('User-Agent'),
            'page' =>   request()->page ? base64_decode(request()->page) : '',
            'lat' => request()->lat ?? '',
            'lon' => request()->lon ?? ''
        ]);
    }

    public function upload(Request $request)
    {
        $url = (new FileService())->imageStore('image');
        return $url . "<br/><img src='$url'>";
    }
}
