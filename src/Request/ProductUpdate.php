<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class ProductUpdate extends HttpRequest implements RequestInterface
{
    protected string $method = 'PATCH';
    protected string $path = '/v1/catalogs/products/{product_id}';

    public function __construct($product_id)
    {
        $this->path = str_replace('{product_id}', $product_id, $this->path);
    }
}