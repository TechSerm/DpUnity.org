<?php

namespace App\Http\Controllers;

use App\Facades\Dashboard\DashboardFacade;
use App\Models\User;
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
        $vendors = User::where(['role_name' => 'vendor'])->get();

        if(auth()->user()->isVendor()){
            request()->order_type = 'wholesale_total';
            request()->vendor = auth()->user()->id;
        }
        
        return view('home', array_merge(DashboardFacade::getDashboardData(), [
            'vendors' => $vendors
        ]));
    }

    private function setStartEndDate()
    {
        $startOfDate = auth()->user()->isCashier() ? Carbon::now()->today() : Carbon::now()->startOfMonth();
        request()->start_date = request()->start_date ?? $startOfDate;
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
