<?php

namespace App\Services\PushNotification;

use App\Models\NotificationDevice;
use App\Services\WooCommerce\WooCommerceService;
use App\Models\PushNotification;

class PushNotificationService
{
    public function notify(PushNotification $pushNotification){
        dd($pushNotification);
        
    }

    public function notifyAll(PushNotification $pushNotification){
        $firebaseTokens = NotificationDevice::whereNotNull('token')->pluck('token')->chunk(1);
        foreach ($firebaseTokens as $firebaseToken) {
            $this->sendNotification($firebaseToken, [
                "title" => $pushNotification->title,
                "body" => $pushNotification->body,
                "url" => $pushNotification->url,
                "largeIcon"=> "https://png.pngtree.com/png-vector/20210703/ourlarge/pngtree-dhamaka-offer-bengali-label-english-meaning-of-blast-png-image_3534938.jpg",
                "bodyImage"=> $pushNotification->image
            ]);
        }
    }

    public function notifyTest(){
        
    }

    public function notifyByIp($ip, $data){
        $firebaseToken = NotificationDevice::where(['last_visit_ip' => $ip])->whereNotNull('token')->pluck('token');
        return $this->sendNotification($firebaseToken, $data);
    }

    public function sendNotification($deviceTokens, $data){
        $SERVER_API_KEY = 'AAAAGN5kMhY:APA91bHq8R97jpbd3wQ31WCPNbDs0sV0tgLyApM7ZmRivwH_td4UuDfYvH_Nw89ngF76VyVdJz5hgY9i-puudFksGcMlTUmSj3QsYyzNsoZWYFOc11zv4a0IARmXPNYl0NQAjVNmKu7-';
        
        $data = array_merge([
            'title' => '',
            'body' => '',
            'url' => '',
            'largeIcon' => '',
            'bodyImage' => '',
        ], $data);

        $postData = [
            "registration_ids" => $deviceTokens,
            "data" => $data
        ];

        $dataString = json_encode($postData);

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

