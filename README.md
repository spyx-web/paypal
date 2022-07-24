# Paypal payment SDk

### [get Test Account](https://developer.paypal.com/)

### [Product list](https://developer.paypal.com/docs/api/catalog-products/v1/#products_list)

```php
try {
    $client = new HttpClient('client_id', 'client_key');
    $product = new ProductList();
    $product->setParams([[
        'headers' => [
            'Authorization' => 'Bearer ' . $client->getAccessToken(),
            'Accept' => 'application/json',
        ],
        'query' => [
            'page_size' => 20,
            'page' => 1,
            'total_required' => 'true'
        ],
    ]]);
    $result = $client->execute($product)->getBody()->getContents();
    dd($result);
} catch (\Exception $exception) {
    dd($exception->getMessage());
}
```