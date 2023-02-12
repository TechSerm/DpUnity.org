<?php

namespace App\Http\Controllers;

use App\Models\NotificationDevice;
use App\Services\DeviceToken\DeviceTokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationDeviceController extends Controller
{
    public function getData(Request $request)
    {
        $deviceQuery = NotificationDevice::where([]);

        if (!request()->get('order')) {
            $deviceQuery = $deviceQuery->orderBy('last_visit_time', 'desc');
        }

        return Datatables::of($deviceQuery)
            ->filter(function ($query) use ($request) {
                $searchValue = isset($request->search) && is_array($request->search) ? $request->search['value'] : '';
                if ($searchValue != '') {
                    $query->where(['last_visit_ip' => $searchValue])->orWhere('last_visit_page', 'like', '%' . $searchValue . '%');
                }
            })
            ->editColumn('last_visit_time', function ($model) use ($request) {
                $dataOb = new Carbon($model->last_visit_time);
                return $dataOb->format('d M y, G:i:s') . ' (' . $dataOb->diffForHumans() . ')';
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('d M y, G:i:s') . ' (' . $model->created_at->diffForHumans() . ')';
            })
            ->make(true);
    }

    public function deviceDashboard()
    {
        return view('dashboard.notification_device', (new DeviceTokenService())->dashboardCalculation());
    }
}
