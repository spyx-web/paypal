# Paypal payment SDk

### [get Test Account](https://developer.paypal.com/)
### [计划列表](https://www.sandbox.paypal.com/billing/plans)
### PaypalClient

```php
 $client = new PaypalClient('client_id', 'client_key');
```

### [Product list](https://developer.paypal.com/docs/api/catalog-products/v1/#products_list)

```php
try {
    $product = new ProductList();
    $product->setParams([
        'headers' => [
            'Authorization' => 'Bearer ' . $client->getAccessToken(),
            'Content-Type' => 'application/json'
        ],
        'query' => [
            'page_size' => '20',
            'page' => '1',
            'total_required' => 'true'
        ],
    ]);
    $result = $client->execute($product)->getBody()->getContents();
    dd($result);
} catch (\Exception $exception) {
    dd($exception->getMessage());
}
```

### [product create](https://developer.paypal.com/docs/api/catalog-products/v1/#products_create)

```php
try {
    $product = new ProductCreate();
    $product->setParams([
        'headers' => [
            'Authorization' => 'Bearer ' . $client->getAccessToken(),
            'Content-Type' => 'application/json',
            'PayPal-Request-Id' => 'PRODUCT-18062020-001'
        ],
        'json' => [
            'name' => 'Video Streaming Service',
            'description' => 'Video streaming service',
            'type' => 'SERVICE',
            'category' => 'SOFTWARE',
            'image_url' => 'https://example.com/streaming.jpg',
            'home_url' => 'https://example.com/home'
        ],
    ]);
    $result = $client->execute($product)->getBody()->getContents();
    dd($result);
} catch (\Exception $exception) {
    dd($exception->getMessage());
}
```

### curl
```bash 
curl -v -X POST https://api-m.sandbox.paypal.com/v1/catalogs/products \
-H "Content-Type: application/json" \
-H "Authorization: Bearer A21AAI0TrH4qXqMqJkh90rCe3OVpSG6YtdCepYz3ACNjgdf6wjJc5tQO5bvqoI8u936HeiINEkUKuYUdJEpZOGewVPwWtTpwQ" \
-H "PayPal-Request-Id: PRODUCT-18062020-001" \
-d '{
  "name": "Video Streaming Service",
  "description": "Video streaming service",
  "type": "SERVICE",
  "category": "SOFTWARE",
  "image_url": "https://example.com/streaming.jpg",
  "home_url": "https://example.com/home"
}'
```

### 打印测试结果

```bash
./vendor/bin/phpunit --colors=always  tests/ProductTest.php
```

```bash 
curl -v -X PATCH https://api-m.sandbox.paypal.com/v1/billing/subscriptions/I-47XX49DWVE2W \
-H "Content-Type: application/json" \
-H "Authorization: Bearer A21AAKgHishv7PXnswOcIjUpue-wo0TZVD0B2Gvq_X3dkMVuGWYjbhF82SyEJmnZt4sJzT7t4jj7uvsh0tYN5AuKmSzJL4H1A" \
-d '[
  {
    "op": "replace",
    "path": "/plan/billing_cycles/@sequence==1/pricing_scheme/fixed_price",
    "value": {
      "currency_code": "USD",
      "value": "50.00"
    }
  },
  {
    "op": "replace",
    "path": "/plan/payment_preferences/auto_bill_outstanding",
    "value": true
  },
  {
    "op": "replace",
    "path": "/plan/payment_preferences/payment_failure_threshold",
    "value": 1
  },
  {
    "op": "replace",
    "path": "/plan/taxes/percentage",
    "value": "10"
  }
]'
```
composer config repositories.paypal path ../paypal