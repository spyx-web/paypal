<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class SubscriptionsPlanList extends HttpRequest implements RequestInterface
{
    protected string $method = 'GET';

    protected string $path = '/v1/billing/plans?product_id={product_id}&page_size={page_size}&page={page}&total_required=true';

    public function __construct($product_id, int $page = 1, int $page_size = 20)
    {
        $this->path = str_replace('{product_id}', $product_id, $this->path);
        $this->path = str_replace('{page}', $page, $this->path);
        $this->path = str_replace('{page_size}', $page_size, $this->path);
    }
}