<?php
return [
    //dashboard
    'dashboard.profit' => ['admin'],
    'dashboard.profit.all_status' => ['admin', 'vendor'],
    'dashboard.profit.cashier' => ['admin', 'cashier'],

    //products
    'products.index' => ['admin', 'vendor', 'cashier', 'delivery_man'],
    'products.create' => ['admin'],
    'products.edit' => ['admin', 'vendor'],
    'products.show' => ['admin', 'vendor'],
    'products.history' => ['admin'],
    'products.delete' => ['super_admin'],


    'products_price.index' => ['admin', 'vendor', 'delivery_man'],
    'products_price.show_vendor' => ['admin', 'delivery_man'],

    //categories
    'categories.index' => ['admin'],
    'categories.create' => ['admin'],
    'categories.edit' => ['admin'],
    'categories.history' => ['admin'],
    'categories.delete' => ['super_admin'],

    'active_orders.index' => ['admin', 'vendor', 'delivery_man'],
    'vendor_payment.index' => ['admin', 'vendor', 'delivery_man'],
    'vendor_payment.add' => ['admin', 'delivery_man'],
    'vendor_payment.confirm' => ['admin', 'vendor'],

    'account.index' => ['admin', 'cashier', 'delivery_man'],
    'order_profit_diposites.index' => ['admin', 'cashier', 'delivery_man'],
    'delivery_transport_costs.index' => ['admin', 'cashier', 'delivery_man'],


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
            'total_profit' => ['admin', 'delivery_man', 'cashier'],
            'wholesale_total' => ['admin', 'delivery_man', 'cashier'],
        ],
        'customer_area' => [
            ['admin', 'delivery_man', 'cashier'],
            'phone_number' => ['admin', 'delivery_man', 'cashier'],
            'edit_info' => ['admin', 'cashier']
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
