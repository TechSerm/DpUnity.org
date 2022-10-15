<?php

namespace App\Http\Controllers;

use App\Facades\Dashboard\DashboardFacade;
use App\Service\Dashboard\DashboardService;
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
        $this->setStartEndDate();
        return view('home', DashboardFacade::getDashboardData());
    }

    private function setStartEndDate()
    {
        request()->start_date = request()->start_date ?? Carbon::now()->startOfMonth();
        request()->end_date = request()->end_date ?? Carbon::now();
    }

    public function log()
    {
        Log::info([
            'time' => Carbon::now()->format('M d Y H:i:s'),
            'ip' => request()->ip(),
            'agent' => request()->header('User-Agent'),
            'page' =>   request()->page ? base64_decode(request()->page) : '',
            'lat' => request()->lat ?? '',
            'lon' => request()->lon ?? ''
        ]);
    }
}
