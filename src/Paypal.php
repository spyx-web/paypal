<?php

namespace Szwtdl\Paypal;

use Szwtdl\Paypal\Request\ProductCreate;
use Szwtdl\Paypal\Request\ProductDetail;
use Szwtdl\Paypal\Request\ProductList;
use Szwtdl\Paypal\Request\ProductUpdate;
use Szwtdl\Paypal\Request\SubscriptionsPlanList;

class Paypal implements PaypalInterface
{
    protected PaypalClient $client;

    public function __construct($client_id, $client_key, $mode = 'prod')
    {
        $this->client = new PaypalClient($client_id, $client_key, $mode);
    }

    public function ProductCreate($name, $description, $type, $category, $image_url, $home_url)
    {
        try {
            $product = new ProductCreate();
            $product->setParams([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'Content-Type' => 'application/json',
                    'PayPal-Request-Id' => 'PRODUCT-18062020-001'
                ],
                'json' => [
                    'name' => $name,
                    'description' => $description,
                    'type' => $type,
                    'category' => $category,
                    'image_url' => $image_url,
                    'home_url' => $home_url
                ],
            ]);
            return json_decode($this->client->execute($product)->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new \Exception("请求异常:" . $exception->getMessage());
        }
    }

    public function ProductList($offset, $limit)
    {
        if (empty($offset) || empty($limit)) {
            throw new \Exception("参数错误");
        }
        try {
            $product = new ProductList();
            $product->setParams([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'Content-Type' => 'application/json'
                ],
                "query" => [
                    'page' => $offset,
                    'page_size' => $limit,
                    'total_required' => 'true'
                ]
            ]);
            $res = json_decode($this->client->execute($product)->getBody()->getContents(), true);
            return [
                'total' => $res['total_items'],
                'list' => $res['products']
            ];
        } catch (\Exception $exception) {
            throw new \Exception("请求异常:" . $exception->getMessage());
        }
    }

    public function ProductDetail($product_id)
    {
        try {
            $product = new ProductDetail($product_id);
            $product->setParams([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'Content-Type' => 'application/json'
                ],
            ]);
            return json_decode($this->client->execute($product)->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new \Exception("请求异常:" . $exception->getMessage());
        }
    }

    public function ProductUpdate($product_id, array $data)
    {
        try {
            $product = new ProductUpdate($product_id);
            $params = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'Content-Type' => 'application/json'
                ],
            ];
            foreach ($data as $key => $val) {
                $params['json'][] = [
                    'op' => 'replace',
                    'path' => '/' . $key,
                    'value' => $val
                ];
            }
            $product->setParams($params);
            return $this->client->execute($product)->getStatusCode() == 204 ? 'success' : 'error';
        } catch (\Exception $exception) {
            throw new \Exception("请求异常:" . $exception->getMessage());
        }
    }

    public function PlansList($product_id, $page, $limit, $total_required = true)
    {
        try {
            $plan = new SubscriptionsPlanList($product_id, $page, $limit);
            $plan->setParams([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'Content-Type' => 'application/json'
                ],
            ]);
            $res = json_decode($this->client->execute($plan)->getBody()->getContents(), true);
            return [
                'total' => $res['total_items'],
                'list' => $res['plans']
            ];
        } catch (\Exception $exception) {
            throw new \Exception("请求异常:" . $exception->getMessage());
        }
    }

    public function PlansCreate($product_id, array $data)
    {
        // TODO: Implement PlansCreate() method.
    }

    public function PlansUpdate($plan_id, $data)
    {
        // TODO: Implement PlansUpdate() method.
    }

    public function PlansUpdatePrice($plan_id, array $data)
    {
        // TODO: Implement PlansUpdatePrice() method.
    }

    public function PlansDetail($plan_id)
    {
        // TODO: Implement PlansDetail() method.
    }

    public function SubscriptionList($plan_id, $start_time, $end_time)
    {
        // TODO: Implement SubscriptionList() method.
    }

    public function SubscriptionCreate($plan_id, array $data)
    {
        // TODO: Implement SubscriptionCreate() method.
    }

    public function SubscriptionUpdate($subscription_id, array $data)
    {
        // TODO: Implement SubscriptionUpdate() method.
    }

    public function SubscriptionDetail($subscription_id)
    {
        // TODO: Implement SubscriptionDetail() method.
    }

    public function SubscriptionActivate($subscription_id, array $data)
    {
        // TODO: Implement SubscriptionActivate() method.
    }

    public function SubscriptionCapture($subscription_id, array $data)
    {
        // TODO: Implement SubscriptionCapture() method.
    }

    public function SubscriptionRevise($subscription_id, array $data)
    {
        // TODO: Implement SubscriptionRevise() method.
    }

    public function SubscriptionSuspend($subscription_id, array $data)
    {
        // TODO: Implement SubscriptionSuspend() method.
    }
}