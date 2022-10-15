<?php

namespace App\Enums\Data;

class OrderStatusEnumData
{
    private static $orderStatusData = [
        'PENDING' => [
            'name' => 'Pending',
            'bnName' => 'পেন্ডিং এ আছে',
            'color' => '#000000'
        ],
        'APPROVED' => [
            'name' => 'Approved',
            'bnName' => 'গ্রহণ করা হয়েছে',
            'color' => '#000000'
        ],
        'ASSIGN_STORE' => [
            'key' => 'Assign Store',
            'name' => 'Assign Store',
            'bnName' => 'বিক্রেতার কাছে পাঠানো হয়েছে',
            'color' => '#000000'
        ],
        'RECEIVED_BY_STORE' => [
            'name' => 'Received By Store',
            'bnName' => 'বিক্রেতা পেয়েছে',
            'color' => '#000000'
        ],
        'PACK_COMPLETE' => [
            'name' => 'Pack Complete',
            'bnName' => 'প্রস্তুতি সম্পন্ন হয়েছে',
            'color' => '#000000'
        ],
        'START_DELIVERY' =>  [
            'name' => 'Delivery Completed',
            'bnName' => 'ডেলিভারি এর জন্য রওনা হয়েছে',
            'color' => '#000000'
        ],
        'DELIVERY_COMPLETED' => [
            'name' => 'Vendor Payment Send',
            'bnName' => 'ডেলিভারি টি সম্পন্ন হয়েছে',
            'color' => '#000000'
        ],
        'VENDOR_PAYMENT_SEND' => [
            'name' => 'Vendor Payment Received',
            'bnName' => 'বিক্রেতার টাকা পাঠানো হয়েছে',
            'color' => '#000000'
        ],
        'VENDOR_PAYMENT_RECEIVED' => [
            'name' => 'Canceled',
            'bnName' => 'বিক্রেতার টাকা পেয়েছে',
            'color' => '#000000'
        ],
        'CANCELED' =>  [
            'name' => 'Canceled',
            'bnName' => 'বাতিল করা হয়েছে',
            'color' => '#000000'
        ]
    ];

    public static function getStatusData($key, $field)
    {
        return isset(self::$orderStatusData[$key]) && isset(self::$orderStatusData[$key][$field]) ? self::$orderStatusData[$key][$field] : '';
    }
}
