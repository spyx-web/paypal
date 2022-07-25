# Paypal payment SDk

### [get Test Account](https://developer.paypal.com/)

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