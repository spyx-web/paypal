<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsPlanActivate extends HttpRequest implements RequestInterface
{
    protected string $method = 'POST';

    protected string $path = '/v1/billing/plans/{plan_id}/activate';

    public function __construct($plan_id)
    {
        $this->path = str_replace('{plan_id}', $plan_id, $this->path);
    }

}