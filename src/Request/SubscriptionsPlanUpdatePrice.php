<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsPlanUpdatePrice extends HttpRequest implements RequestInterface
{
    protected string $method = 'PATCH';

    protected string $path = '/v1/billing/plans/{plan_id}/update-pricing-schemes';

    public function __construct($plan_id)
    {
        $this->path = str_replace('{plan_id}', $plan_id, $this->path);
    }
}