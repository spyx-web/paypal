<?php

use Szwtdl\Paypal\PaypalClient;
use Szwtdl\Paypal\Request\ProductList;
use Szwtdl\Paypal\Request\ProductCreate;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $client = new PaypalClient('AQHcKDQueGSoG0-3ZpzSMbAu8DBuJOYe6qbyU-oERc_dVPi04af0_YWv_oSSBGZNJ28x2amjtQDky5k4', 'EBZNdZU5ngG9_GdOuTp1plKLOLzkfrtd4XvZkJJ6Zia5ZBu7Gy-lPDcqGjFvc5kcI2fWX78dh7Gg9oF2');

    $product = new \Szwtdl\Paypal\Request\SubscriptionsPlanList('PROD-9BS17405V1521584R',1,20);
    $product->setParams([
        'headers' => [
            'Authorization' => 'Bearer ' . $client->getAccessToken(),
            'Content-Type' => 'application/json',
        ],
    ]);


//    $product = new \Szwtdl\Paypal\Request\ProductDetail('PROD-5JM733700L217413N');
//    $product->setParams([
//        'headers' => [
//            'Authorization' => 'Bearer ' . $client->getAccessToken(),
//            'Content-Type' => 'application/json',
//            'PayPal-Request-Id' => 'PRODUCT-18062020-001'
//        ],
//        'json' => [
//            'name' => 'Video Streaming Service',
//            'description' => 'Video streaming service',
//            'type' => 'SERVICE',
//            'category' => 'SOFTWARE',
//            'image_url' => 'https://example.com/streaming.jpg',
//            'home_url' => 'https://example.com/home'
//        ],
//    ]);
    $result = $client->execute($product)->getBody()->getContents();
    dd($result);
} catch (\Exception $exception) {
    dd($exception->getMessage());
}