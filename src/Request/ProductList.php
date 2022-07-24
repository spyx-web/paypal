<?php

namespace Szwtdl\Paypal\Request;

use Szwtdl\Paypal\HttpRequest;
use Szwtdl\Paypal\RequestInterface;

class ProductList extends HttpRequest implements RequestInterface
{
    protected string $method = 'GET';
    protected string $path = 'v1/catalogs/products';
    protected array $params = [
        'query' => [
            'page_size' => '20',
            'page' => '1',
            'total_required' => 'true'
        ],
    ];

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $this->params = $this->params + $params;
    }

}