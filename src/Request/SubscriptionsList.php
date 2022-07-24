<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsList extends HttpRequest implements RequestInterface
{
    protected string $method = 'GET';

}