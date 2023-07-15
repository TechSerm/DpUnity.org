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
        $deviceQuery = NotificationDevice::with('history');

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
            ->editColumn('hits', function ($model) use ($request) {
                return $model->history->count() > 0 ? $model->history->count() : $model->hits;
            })
            ->editColumn('last_visit_time', function ($model) use ($request) {
                $history = $model->history->last();
                $time = $history ? $history->created_at : new Carbon($model->last_visit_time);
                return $time->format('d M y, G:i:s') . ' (' . $time->diffForHumans() . ')';
            })
            ->editColumn('last_visit_page', function ($model) use ($request) {
                $history = $model->history->last();
                return $history ? $history->shortUrl() : $model->last_visit_page;
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('d M y, G:i:s') . ' (' . $model->created_at->diffForHumans() . ')';
            })
            ->addColumn('action', function ($model) {

                $content = "<button data-url='" . route('notification_device.show', ['notification_device_id' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Device Info <b>#" . $model->id . "</b>'
                data-modal-size='lg' data-toggle='modal'><i class='fa fa-history'></i></button>";

                return $content;
            })
            ->make(true);
    }

    public function show($id)
    {
        $device = NotificationDevice::findOrFail($id);
        return view('device.show', [
            'device' => $device
        ]);
    }

    public function deviceDashboard()
    {
        return view('dashboard.notification_device', (new DeviceTokenService())->dashboardCalculation());
    }
}
