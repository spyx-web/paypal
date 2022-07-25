<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsPriceUpdate extends HttpRequest implements RequestInterface
{
    protected string $method = 'PATCH';
    protected string $path = '/v1/billing/subscriptions/';

}