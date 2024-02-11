<?php

namespace App\Enums\Data;

class OrderStatusEnumData
{
    private static $orderStatusData = [
        'PROCESSING' => [
            'color' => '#2980b9',
        ],
        'CONFIRMED' => [
            'color' => '#2980b9',
        ],
        
        'SHIPPED' => [
            'color' => '#2980b9',
        ],

        'DELIVERED' => [
            'color' => '#27ae60',
        ],

        'COMPLETED' => [
            'color' => '#27ae60',
        ],
        
        'CANCELED' =>  [
            'color' => '#c0392b',
        ]
    ];

    public static function getStatusData($key, $field)
    {
        return isset(self::$orderStatusData[$key]) && isset(self::$orderStatusData[$key][$field]) ? self::$orderStatusData[$key][$field] : '';
    }
}
