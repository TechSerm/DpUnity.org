<?php

namespace App\Enums\Data;

class OrderStatusEnumData
{
    private static $orderStatusData = [
        'PENDING' => [
            'name' => 'Pending',
            'bnName' => 'পেন্ডিং এ আছে',
            'customerStatus' => [
                'name' => 'অর্ডারটি পেন্ডিং এ আছে',
                'color' => '#ffeaa7',
            ],
            'color' => '#000000',
            'notificationMessage' => []
        ],
        'APPROVED' => [
            'name' => 'Approved',
            'bnName' => 'গ্রহণ করা হয়েছে',
            'customerStatus' => [
                'name' => 'অর্ডারটি গ্রহণ করা হয়েছে',
                'color' => '#a0b9e9',
            ],
            'color' => '#000000',
            'notificationMessage' => [
                'customer' => 'আপনার অর্ডারটি গ্রহণ করা হয়েছে',
                'admin' => 'অর্ডারটি গ্রহণ করা হয়েছে',
            ]
        ],
        'ASSIGN_STORE' => [
            'key' => 'Assign Store',
            'name' => 'Assign Store',
            'bnName' => 'বিক্রেতার কাছে পাঠানো হয়েছে',
            'customerStatus' => [
                'name' => 'অর্ডারটি গ্রহণ করা হয়েছে',
                'color' => '#a0b9e9',
            ],
            'color' => '#000000',
            'notificationMessage' => [
                'customer' => 'আপনার অর্ডারটি বিক্রেতার কাছে পাঠানো হয়েছে',
                'vendor' => 'আপনার নতুন একটি অর্ডার এসেছে, অর্ডারটি গ্রহণ করুন',
                'admin' => 'অর্ডারটি বিক্রেতার কাছে পাঠানো হয়েছে'
            ]
        ],
        'RECEIVED_BY_STORE' => [
            'name' => 'Received By Store',
            'bnName' => 'বিক্রেতা পেয়েছে',
            'customerStatus' => [
                'name' => 'অর্ডারটির প্রস্তুতি চলছে',
                'color' => '#a0b9e9',
            ],
            'color' => '#000000',
            'notificationMessage' => [
                'customer' => 'আপনার অর্ডারটির প্রস্তুতি চলছে',
                'admin' => 'অর্ডারটির প্রস্তুতি চলছে'
            ]
        ],
        'PACK_COMPLETE' => [
            'name' => 'Pack Complete',
            'bnName' => 'প্রস্তুতি সম্পন্ন হয়েছে',
            'customerStatus' => [
                'name' => 'অর্ডারটির প্রস্তুতি সম্পন্ন হয়েছে',
                'color' => '#a0b9e9',
            ],
            'color' => '#000000',
            'notificationMessage' => [
                'customer' => 'আপনার অর্ডারটির প্রস্তুতি সম্পন্ন হয়েছে',
                'admin' => 'অর্ডারটির প্রস্তুতি সম্পন্ন হয়েছে'
            ]
        ],
        'START_DELIVERY' =>  [
            'name' => 'Delivery Completed',
            'bnName' => 'ডেলিভারির জন্য রওনা হয়েছে',
            'customerStatus' => [
                'name' => 'ডেলিভারি ম্যান অর্ডারটি ডেলিভারির জন্য রওনা হয়েছে',
                'color' => '#a0b9e9',
            ],
            'color' => '#000000',
            'notificationMessage' => [
                'customer' => 'আপনার অর্ডারটি ডেলিভারির জন্য ডেলিভারি ম্যান রওনা হয়েছে',
                'admin' => 'ডেলিভারির জন্য রওনা হয়েছে'
            ]
        ],
        'DELIVERY_COMPLETED' => [
            'name' => 'Vendor Payment Send',
            'bnName' => 'ডেলিভারি টি সম্পন্ন হয়েছে',
            'customerStatus' => [
                'name' => 'অর্ডারটির ডেলিভারি সম্পন্ন হয়েছে',
                'color' => '#7bed9f',
            ],
            'color' => '#000000',
            'notificationMessage' => [
                'customer' => 'আপনার অর্ডারটির ডেলিভারি সম্পন্ন হয়েছে',
                'vendor' => 'অর্ডারটির ডেলিভারি সম্পন্ন হয়েছে',
                'admin' => 'অর্ডারটির ডেলিভারি সম্পন্ন হয়েছে'
            ]
        ],
        'VENDOR_PAYMENT_SEND' => [
            'name' => 'Vendor Payment Received',
            'bnName' => 'বিক্রেতার টাকা পাঠানো হয়েছে',
            'customerStatus' => [
                'name' => 'অর্ডারটির ডেলিভারি সম্পন্ন হয়েছে',
                'color' => '#7bed9f',
            ],
            'color' => '#000000',
            'notificationMessage' => [
                'vendor' => 'অর্ডার এর টাকা আপনাকে পাঠানো হয়েছে , টাকা গ্রহণ করুন',
                'admin' => 'বিক্রেতার টাকা পাঠানো হয়েছে'
            ]
        ],
        'VENDOR_PAYMENT_RECEIVED' => [
            'name' => 'Canceled',
            'bnName' => 'বিক্রেতা টাকা পেয়েছে',
            'customerStatus' => [
                'name' => 'অর্ডারটির ডেলিভারি সম্পন্ন হয়েছে',
                'color' => '#7bed9f',
            ],
            'color' => '#000000',
            'notificationMessage' => [
                'admin' => 'বিক্রেতা টাকা পেয়েছে'
            ]
        ],
        'CANCELED' =>  [
            'name' => 'Canceled',
            'bnName' => 'বাতিল করা হয়েছে',
            'customerStatus' => [
                'name' => 'অর্ডারটি বাতিল করা হয়েছে',
                'color' => '#fab1a0',
            ],
            'color' => '#000000',
            'notificationMessage' => [
                'customer' => 'আপনার অর্ডারটি বাতিল করা হয়েছে',
                'admin' => 'অর্ডারটি বাতিল করা হয়েছে'
            ]
        ]
    ];

    public static function getStatusData($key, $field)
    {
        return isset(self::$orderStatusData[$key]) && isset(self::$orderStatusData[$key][$field]) ? self::$orderStatusData[$key][$field] : '';
    }
}
