<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class OrderDetail extends HttpRequest implements RequestInterface
{
    protected string $method = "GET";
    protected string $path = "/v2/checkout/orders/{order_id}";

    public function __construct($order_id)
    {
        $this->path = str_replace('{order_id}', $order_id, $this->path);
    }
}