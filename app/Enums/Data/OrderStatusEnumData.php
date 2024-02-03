<?php

namespace App\Enums\Data;

class OrderStatusEnumData
{
    private static $orderStatusData = [
        'PROCESSING' => [
            'color' => '#34495e',
        ],
        'CONFIRMED' => [
            'color' => '#8e44ad',
        ],
        
        'SHIPPED' => [
            'color' => '#8e44ad',
        ],

        'DELIVERED' => [
            'color' => '#8e44ad',
        ],

        'COMPLETED' => [
            'color' => '#8e44ad',
        ],
        
        'CANCELED' =>  [
            'color' => '#c23616',
        ]
    ];

    public static function getStatusData($key, $field)
    {
        return isset(self::$orderStatusData[$key]) && isset(self::$orderStatusData[$key][$field]) ? self::$orderStatusData[$key][$field] : '';
    }
}
