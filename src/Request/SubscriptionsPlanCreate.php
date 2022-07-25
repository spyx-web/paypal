<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsPlanCreate extends HttpRequest implements RequestInterface
{
    protected string $method = 'POST';

    protected string $path = '/v1/billing/plans';


}