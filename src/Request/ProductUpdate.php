<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class ProductUpdate extends HttpRequest implements RequestInterface
{
    protected string $method = 'PATCH';
    protected string $path = '/v1/catalogs/products/PROD-60596544C0782344A';
}