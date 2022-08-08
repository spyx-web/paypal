# Paypal payment SDk

#### Installation

You can add this library as a local, per-project dependency to your project using Composer:

```bash 
composer require szwtdl/paypal
```

#### paypal

```bash 
use Szwtdl\Paypal\Paypal

$paypal = new Paypal('client_id','client_key','dev')

```

#### laravel

在刚刚创建的应用里，我们需要更新一下配置文件 `config/services.php`，添加以下部分：

config/services.php

```bash 

'paypal' => [
    'client_id' => '',
    'client_key' => '',
    'mode' => 'prod',
]

```

#### [ProductCreate](https://developer.paypal.com/docs/api/catalog-products/v1/#products_create)

```bash 
$paypal->ProductCreate("每天订购", "每天sand", 'SERVICE', 'SOFTWARE', 'https://example.com/streaming.jpg', 'https://example.com/home');
```

#### [ProductList](https://developer.paypal.com/docs/api/catalog-products/v1/#products_list)

```bash 
$paypal->ProductList(1,20)
```

#### [ProductDetail](https://developer.paypal.com/docs/api/catalog-products/v1/#products_get)
```bash 
$paypal->ProductDetail("PROD-8RU94658131561729")
```

#### [ProductUpdate](https://developer.paypal.com/docs/api/catalog-products/v1/#products_patch)
```bash
$paypal->ProductUpdate("PROD-8RU94658131561729", [
    'description' => 'xxx'
]);
```

#### [PlansList](https://developer.paypal.com/docs/api/subscriptions/v1/#plans_list)

```bash 
$paypal->PlansList('PROD-8RU94658131561729', 1, 10, true);
```

#### [PlansCreate](https://developer.paypal.com/docs/api/subscriptions/v1/#plans_create)

```bash 
$paypal->PlansCreate([
    'product_id' => 'PROD-8RU94658131561729',
    'name' => '优酷年会员',
    'description' => '定期续费',
    'status' => 'ACTIVE',
    'billing_cycles' => [
        [
            'frequency' => [
                'interval_unit' => 'MONTH',
                'interval_count' => 3
            ],
            'tenure_type' => 'REGULAR',
            'sequence' => 1,
            'total_cycles' => 0,
            'pricing_scheme' => [
                'fixed_price' => [
                    'value' => 20.99,
                    'currency_code' => 'USD'
                ]
            ]
        ]
    ],
    'payment_preferences' => [
        'auto_bill_outstanding' => true,
        'setup_fee' => [
            'value' => 0,
            'currency_code' => 'USD'
        ],
        'setup_fee_failure_action' => 'CONTINUE',
        'payment_failure_threshold' => 3
    ],
    'taxes' => [
        'percentage' => 0,
        'inclusive' => false
    ]
]);
```

#### [PlansUpdate](https://developer.paypal.com/docs/api/subscriptions/v1/#plans_patch)

```bash
$paypal->PlansUpdate("P-0BL89979RT255525KMLQP5AA", [
    'description' => '新产品'
]);
```

#### [PlansDetail]()

#### [PlansActivate]()

#### [PlansDeactivate]()

#### [SubscriptionCreate]()

#### [SubscriptionList]()

#### [SubscriptionDetail]()

#### [SubscriptionActivate]()