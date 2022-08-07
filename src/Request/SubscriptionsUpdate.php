<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsUpdate extends HttpRequest implements RequestInterface
{
    protected string $method = 'PATCH';
    protected string $path = '/v1/billing/subscriptions/{id}';

    public function __construct($subscription_id)
    {
        $this->path = str_replace('{id}', $subscription_id, $this->path);
    }
}