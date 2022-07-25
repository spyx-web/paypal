<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsDetail extends HttpRequest implements RequestInterface
{
    protected string $method = 'GET';
    protected string $path = '/v1/billing/subscriptions/{id}';

    public function __construct($id)
    {
        $this->path = str_replace('{id}', $id, $this->path);
    }
}