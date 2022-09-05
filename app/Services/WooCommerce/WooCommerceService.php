<?php

namespace App\Services\WooCommerce;

use Automattic\WooCommerce\Client;

class WooCommerceService
{

    public static function connect()
    {
        $woocommerce = new Client(
            'https://bibisena.com/', // Your store URL
            'ck_e12eb3b17aadeff7c6b8b368dcecc8405ad04a4e', // Your consumer key
            'cs_d30dd3ccab831edcc77b172e2088ac27e497e626', // Your consumer secret
            [
                'wp_api' => true, // Enable the WP REST API integration
                'version' => 'wc/v3' // WooCommerce WP REST API version
            ]
        );

        return $woocommerce;
    }
}
