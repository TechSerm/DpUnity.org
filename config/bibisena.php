<?php
return [
    'mobile_number' => env('STORE_MOBILE_NUMBER', '01777564786'), // 'bar' is default if MY_VALUE is missing in .env
    'default_delivery_fee' => env('DEFAULT_DELIVERY_FEE', 19),
    'android_app_version' => env('BIBISENA_ANDROID_APP_VERSION', '1.1.1'),
    'push_notification_enabled' => env('PUSH_NOTIFICATION_ENABLED', true),
    'export_key' => env('EXPORT_KEY', '')
];
