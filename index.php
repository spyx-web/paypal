<?php

use Szwtdl\Paypal\Paypal;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $paypal = new Paypal('AQHcKDQueGSoG0-3ZpzSMbAu8DBuJOYe6qbyU-oERc_dVPi04af0_YWv_oSSBGZNJ28x2amjtQDky5k4', 'EBZNdZU5ngG9_GdOuTp1plKLOLzkfrtd4XvZkJJ6Zia5ZBu7Gy-lPDcqGjFvc5kcI2fWX78dh7Gg9oF2', 'dev');
//    $result = $paypal->ProductList(1, 5);
//    $result = $paypal->ProductCreate("每天订购", "每天sand", 'SERVICE', 'SOFTWARE', 'https://example.com/streaming.jpg', 'https://example.com/home');
//    $result = $paypal->ProductDetail("PROD-8RU94658131561729");
//    $result = $paypal->ProductUpdate("PROD-8RU94658131561729", [
//        'description' => '我是你慢慢'
//    ]);
//    $result = $paypal->PlansCreate([
//        'product_id' => 'PROD-8RU94658131561729',
//        'name' => '优酷年会员',
//        'description' => '定期续费',
//        'status' => 'ACTIVE',
//        'billing_cycles' => [
//            [
//                'frequency' => [
//                    'interval_unit' => 'MONTH',
//                    'interval_count' => 3
//                ],
//                'tenure_type' => 'REGULAR',
//                'sequence' => 1,
//                'total_cycles' => 0,
//                'pricing_scheme' => [
//                    'fixed_price' => [
//                        'value' => 20.99,
//                        'currency_code' => 'USD'
//                    ]
//                ]
//            ]
//        ],
//        'payment_preferences' => [
//            'auto_bill_outstanding' => true,
//            'setup_fee' => [
//                'value' => 0,
//                'currency_code' => 'USD'
//            ],
//            'setup_fee_failure_action' => 'CONTINUE',
//            'payment_failure_threshold' => 3
//        ],
//        'taxes' => [
//            'percentage' => 0,
//            'inclusive' => false
//        ]
//    ]);
//    $result = $paypal->PlansList('PROD-8RU94658131561729', 1, 10, true);
//    $result = $paypal->PlansDetail('P-0BL89979RT255525KMLQP5AA');
//    $result = $paypal->PlansDetail('P-4VL995828C819852BMLX3YTQ');
//    $result = $paypal->PlansActivate('P-0BL89979RT255525KMLQP5AA');
//    $result = $paypal->PlansDeactivate('P-0BL89979RT255525KMLQP5AA');
//    $result = $paypal->PlansUpdate('P-0BL89979RT255525KMLQP5AA', ['description' => '新产品']);

//    $result = $paypal->SubscriptionCreate([
//        'plan_id' => 'P-4VL995828C819852BMLX3YTQ',
//        'start_time' => '2022-08-08T00:00:00Z',
//        'application_context' => [
//            'brand_name' => 'xxx',
//            'shipping_preference' => 'SET_PROVIDED_ADDRESS',
//            'user_action' => 'SUBSCRIBE_NOW',
//            'payment_method' => [
//                'payer_selected' => 'PAYPAL',
//                'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED'
//            ],
//            'return_url' => 'https://spyx.com',
//            'cancel_url' => 'https://spyx.com/demo'
//        ]
//    ]);
//    $result = $paypal->SubscriptionList('I-47XX49DWVE2W','2020-01-21T07:50:20.940Z','2022-08-21T07:50:20.940Z');
//    $result = $paypal->SubscriptionDetail('I-47XX49DWVE2W');
//      $result = $paypal->SubscriptionDetail('I-FFV9L1EEFHCH');
//    $result = $paypal->SubscriptionActivate('I-47XX49DWVE2W', [
//        'reason' => 'Reactivating the subscription'
//    ]);
    $result = $paypal->SubscriptionUpdate('I-FFV9L1EEFHCH', [
        'plan/billing_cycles/@sequence==1/pricing_scheme/fixed_price' => [
            'currency_code' => 'USD',
            'value' => 60.00
        ],
        'plan/payment_preferences/auto_bill_outstanding' => 'true',
        'plan/payment_preferences/payment_failure_threshold' => 1,
        'plan/taxes/percentage' => 10
    ]);
    dd($result);
} catch (\Exception $exception) {
    dd($exception->getMessage());
}