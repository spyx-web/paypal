<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class ProductList extends HttpRequest implements RequestInterface
{
    protected string $method = 'GET';
    protected string $path = 'v1/catalogs/products';

}