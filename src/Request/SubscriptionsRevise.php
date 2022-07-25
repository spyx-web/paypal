<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsRevise extends HttpRequest implements RequestInterface
{
    protected string $method = 'POST';
    protected string $path = '/v1/billing/subscriptions/{id}/revise';

    public function __construct($id)
    {
        $this->path = str_replace('{id}', $id, $this->path);
    }
}