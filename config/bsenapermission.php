<?php
return [
    //dashboard
    'dashboard.profit' => ['admin'],
    'dashboard.profit.all_status' => ['admin', 'vendor'],
    'dashboard.profit.cashier' => ['admin', 'cashier'],

    //products
    'products.index' => ['admin', 'vendor', 'cashier'],
    'products.create' => ['admin'],
    'products.edit' => ['admin', 'vendor'],
    'products.show' => ['admin', 'vendor'],
    'products.history' => ['admin'],
    'products.delete' => ['super_admin'],


    'products_price.index' => ['admin', 'vendor'],

    //categories
    'categories.index' => ['admin'],
    'categories.create' => ['admin'],
    'categories.edit' => ['admin'],
    'categories.history' => ['admin'],
    'categories.delete' => ['super_admin'],

    'active_orders.index' => ['admin', 'vendor', 'delivery_man'],
    'vendor_payment.index' => ['admin', 'vendor'],

    'account.index' => ['admin', 'cashier'],
    'order_profit_diposites.index' => ['admin', 'cashier'],
    'delivery_transport_costs.index' => ['admin', 'cashier'],


    /*
    |--------------------------------------------------------------------------
    | Order
    |--------------------------------------------------------------------------
    */
    'order' => [
        'info' => [
            'ip' => ['admin'],
            'app_version' => ['admin'],
            'order_date' => ['admin', 'delivery_man'],
            'cancel_order' => ['admin'],
            'history' => ['admin'],
            'total_profit' => ['admin', 'delivery_man'],
            'wholesale_total' => ['admin', 'delivery_man'],
        ],
        'customer_area' => [
            ['admin', 'delivery_man'],
            'phone_number' => ['admin', 'delivery_man'],
            'edit_info' => ['admin']
        ],
        'items' => [
            'vendor_name' => ['admin', 'delivery_man'],
            'edit' => ['admin'],
            'delete' => ['admin'],
            'add' => ['admin'],
            'profit_column' => ['admin']
        ],
        'status' => [
            'approved' => ['admin'],
            'assign_vendor' => ['admin'],
            'pack_complete' => ['admin','delivery_man'],
            'start_delivery' => ['admin','delivery_man'],
            'complete_delivery' => ['admin','delivery_man'],
        ]
    ]
];
