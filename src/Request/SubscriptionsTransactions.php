<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsTransactions extends HttpRequest implements RequestInterface
{
    protected string $method = 'GET';
    protected string $path = '/v1/billing/subscriptions/{id}/transactions?start_time={start_time}&end_time={end_time}';

    public function __construct($id,$start_time,$end_time)
    {
        $this->path = str_replace('{id}', $id, $this->path);
        $this->path = str_replace('{start_time}', $start_time, $this->path);
        $this->path = str_replace('{end_time}', $end_time, $this->path);
    }

}