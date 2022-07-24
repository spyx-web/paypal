# Paypal payment SDk

### [product list](https://www.paypal.com)

```php
$request = new \Szwtdl\Paypal\Request\ProductList();
$request->setParams([
    
]);
$client = new \Szwtdl\Paypal\HttpClient();
$result = $client->execute($request)->getBody()->getContents();
var_dump($result);
```