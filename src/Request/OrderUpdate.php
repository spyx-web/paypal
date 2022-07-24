<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class OrderUpdate extends HttpRequest implements RequestInterface
{
    protected string $method = "PATCH";
    protected string $path = "/v2/checkout/orders/2YW58531LG196334G";
}