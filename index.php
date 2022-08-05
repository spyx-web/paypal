<?php

use Szwtdl\Paypal\Paypal;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $paypal = new Paypal('AQHcKDQueGSoG0-3ZpzSMbAu8DBuJOYe6qbyU-oERc_dVPi04af0_YWv_oSSBGZNJ28x2amjtQDky5k4', 'EBZNdZU5ngG9_GdOuTp1plKLOLzkfrtd4XvZkJJ6Zia5ZBu7Gy-lPDcqGjFvc5kcI2fWX78dh7Gg9oF2', 'dev');
//    $result = $paypal->ProductList(1, 5);
//    $result = $paypal->ProductCreate("您好的产品", "每天sand", 'SERVICE', 'SOFTWARE', 'https://example.com/streaming.jpg', 'https://example.com/home');
//    $result = $paypal->ProductDetail("PROD-8RU94658131561729");
//    $result = $paypal->ProductUpdate("PROD-8RU94658131561729",[
//        'description' => '我是你慢慢'
//    ]);
    $result = $paypal->PlansList('PROD-1WM99533L4866094Y', 1, 20);
    dd($result);
} catch (\Exception $exception) {
    dd($exception->getMessage());
}