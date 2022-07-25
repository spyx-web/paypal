<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class OrderCreate extends HttpRequest implements RequestInterface
{
    protected string $method = "POST";
    protected string $path = "/v2/checkout/orders";


}