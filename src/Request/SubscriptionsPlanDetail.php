<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsPlanDetail extends HttpRequest implements RequestInterface
{
    protected string $method = 'GET';

    protected string $path = '/v1/billing/plans/{plan_id}';

    public function __construct($plan_id)
    {
        $this->path = str_replace('{plan_id}', $plan_id, $this->path);
    }
}