<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class OrderCapture extends HttpRequest implements RequestInterface
{
    protected string $method = "POST";
    protected string $path = "/v2/checkout/orders/{order_id}/capture";

    public function __construct($order_id)
    {
        $this->path = str_replace('{order_id}', $order_id, $this->path);
    }
}