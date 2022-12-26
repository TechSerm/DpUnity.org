<?php

namespace App\Http\Controllers;

use App\Models\NotificationDevice;
use App\Models\PushNotification;
use App\Services\PushNotification\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PushNotificationController extends Controller
{
    private $pushNotificationService;
    public function __construct(PushNotificationService $pushNotificationService)
    {
        $this->pushNotificationService = $pushNotificationService;
    }

    public function index()
    {
        return view("push_notification.index", [
            'notifications' => PushNotification::all()
        ]);
    }

    public function getData(Request $request)
    {
        $pushNotificationQuery = PushNotification::with('clicks');

        if (!request()->get('order')) {
            $pushNotificationQuery = $pushNotificationQuery->orderBy('id', 'desc');
        }
        return Datatables::of($pushNotificationQuery)
            ->filter(function ($query) use ($request) {
            })
            ->editColumn('image', function ($model) {
                return "<img src='" . $model->image . "' height='50px' width='50px' class='img-fluid img-thumbnail'>";
            })
            ->editColumn('url', function ($model) {
                return "<a href=" . $model->url . ">" . $model->url . "</a>";
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->diffForHumans();
            })
            ->addColumn('total_clicks', function ($model) {
                return $model->clicks->count();
            })
            ->orderColumn('total_clicks', function ($query, $order) use ($pushNotificationQuery) {
               // dd($pushNotificationQuery->orderBy('ip', $order)->toSql());
                //$query->clicks()->orderBy('order_notification_clicks.ip', $order);
            })
            ->addColumn('action', function ($model) {
                
                return "";
            })
            ->make(true);
    }


    public function create()
    {
        return view('push_notification.create');
    }

    public function store(Request $request)
    {
        $pushNotification = PushNotification::create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'body' => $request->body,
            'url' => $request->url,
            'image' => $request->image,
        ]);

        $totalSuccessfullySend = $this->pushNotificationService->notifyAll($pushNotification);

        return response()->json([
            'message' => 'Notification Successfully Send ' . $totalSuccessfullySend . ' Device'
        ]);
    }

    public function show()
    {
        return view('category.create');
    }

    public function edit()
    {
        return view('category.create');
    }

    public function update()
    {
        return view('category.create');
    }

    public function delete()
    {
        return view('category.create');
    }
}
