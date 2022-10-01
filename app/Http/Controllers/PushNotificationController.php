<?php

namespace App\Http\Controllers;

use App\Models\NotificationDevice;
use App\Models\PushNotification;
use App\Services\PushNotification\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $this->pushNotificationService->notifyAll($pushNotification);
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

    public function sendPushNotification()
    {
    }

    public function sendTestPushNotification(Request $request)
    {
        $firebaseToken = NotificationDevice::whereNotNull('token')->pluck('token')->all();

        $SERVER_API_KEY = 'AAAAGN5kMhY:APA91bHq8R97jpbd3wQ31WCPNbDs0sV0tgLyApM7ZmRivwH_td4UuDfYvH_Nw89ngF76VyVdJz5hgY9i-puudFksGcMlTUmSj3QsYyzNsoZWYFOc11zv4a0IARmXPNYl0NQAjVNmKu7-';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "বিবিসিনার বিশেষ অফার",
                "body" => "মাত্র 38 টাকা ✌️ কেজি তে পেঁয়াজ কিনুন",
            ],
            "data" => [
                "url" => "http://192.168.31.7:8080/order?notification_id=123456",
                "image" => "https://chaldn.com/_mpimage/paka-pape-50-gm-1-kg?src=https%3A%2F%2Feggyolk.chaldal.com%2Fapi%2FPicture%2FRaw%3FpictureId%3D23193&q=low&v=1"
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return $response;
    }
}
