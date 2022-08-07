<?php

namespace Szwtdl\Paypal;

use Szwtdl\Paypal\Exceptions\HttpException;
use Szwtdl\Paypal\Exceptions\InvalidArgumentException;
use Szwtdl\Paypal\Request\ProductCreate;
use Szwtdl\Paypal\Request\ProductDetail;
use Szwtdl\Paypal\Request\ProductList;
use Szwtdl\Paypal\Request\ProductUpdate;
use Szwtdl\Paypal\Request\SubscriptionsPlanActivate;
use Szwtdl\Paypal\Request\SubscriptionsPlanCreate;
use Szwtdl\Paypal\Request\SubscriptionsPlanDeactivate;
use Szwtdl\Paypal\Request\SubscriptionsPlanDetail;
use Szwtdl\Paypal\Request\SubscriptionsPlanList;
use Szwtdl\Paypal\Request\SubscriptionsPlanUpdate;
use Szwtdl\Paypal\Request\SubscriptionsPlanUpdatePrice;
use Szwtdl\Paypal\Request\SubscriptionsActivate;
use Szwtdl\Paypal\Request\SubscriptionsCancel;
use Szwtdl\Paypal\Request\SubscriptionsCapture;
use Szwtdl\Paypal\Request\SubscriptionsCreate;
use Szwtdl\Paypal\Request\SubscriptionsDetail;
use Szwtdl\Paypal\Request\SubscriptionsList;
use Szwtdl\Paypal\Request\SubscriptionsRevise;
use Szwtdl\Paypal\Request\SubscriptionsSuspend;
use Szwtdl\Paypal\Request\SubscriptionsUpdate;

class Paypal implements PaypalInterface
{
    protected $client;

    public function __construct($client_id, $client_key, $mode = 'prod')
    {
        $this->client = new PaypalClient($client_id, $client_key, $mode);
    }

    public function ProductCreate($name, $description, $type, $category, $image_url, $home_url)
    {
        if (empty($name) || empty($description) || empty($type) || empty($category) || empty($image_url) || empty($home_url)) {
            throw new InvalidArgumentException("Invalid name description type category image_url home_url");
        }
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
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function ProductList($offset, $limit)
    {
        if (empty($offset) || empty($limit)) {
            throw new InvalidArgumentException("Invalid offset or limit null");
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
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function ProductDetail($product_id)
    {
        if (empty($product_id)) throw new InvalidArgumentException("Invalid product_id not null");
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
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function ProductUpdate($product_id, $data)
    {
        if (empty($product_id) || !is_array($data)) throw new InvalidArgumentException("Invalid product_id null or data not array");
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
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function PlansList($product_id, $page, $limit, $total_required = true)
    {
        if (empty($product_id)) {
            throw new InvalidArgumentException("Invalid product_id null");
        }
        if (empty($page)) {
            throw new InvalidArgumentException("Invalid page null");
        }
        if (empty($limit)) {
            throw new InvalidArgumentException("Invalid page_size null");
        }
        if (!\in_array($total_required, [true, false])) {
            throw new InvalidArgumentException("Invalid total_required true or false");
        }
        try {
            $plan = new SubscriptionsPlanList();
            $plan->setParams([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'Content-Type' => 'application/json'
                ],
                'query' => [
                    'product_id' => $product_id,
                    'page' => $page,
                    'page_size' => $limit,
                    'total_required' => $total_required === true ? 'true' : 'false'
                ]
            ]);
            $res = json_decode($this->client->execute($plan)->getBody()->getContents(), true);
            return [
                'total' => isset($res['total_items']) ? trim($res['total_items']) : 0,
                'list' => $res['plans']
            ];
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function PlansCreate($data)
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data array");
        }
        if (!isset($data['product_id'])) {
            throw new InvalidArgumentException("Invalid product_id null");
        }
        if (!isset($data['name'])) {
            throw new InvalidArgumentException("Invalid name null");
        }
        if (!isset($data['billing_cycles'])) {
            throw new InvalidArgumentException("Invalid billing_cycles null");
        }
        try {
            $plan = new SubscriptionsPlanCreate();
            $plan->setParams([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'Content-Type' => 'application/json',
                    'PayPal-Request-Id' => 'PLAN-18062019-001'
                ],
                'json' => $data
            ]);
            return json_decode($this->client->execute($plan)->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function PlansUpdate($plan_id, $data)
    {
        if (empty($plan_id)) {
            throw new InvalidArgumentException("Invalid plan_id null");
        }
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data array");
        }
        try {
            $product = new SubscriptionsPlanUpdate($plan_id);
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
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function PlansDetail($plan_id)
    {
        if (empty($plan_id)) {
            throw new InvalidArgumentException("Invalid plan_id null");
        }
        try {
            $plan = new SubscriptionsPlanDetail($plan_id);
            $plan->setParams([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'Content-Type' => 'application/json',
                ],
            ]);
            return json_decode($this->client->execute($plan)->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function PlansActivate($plan_id)
    {
        if (empty($plan_id)) {
            throw new InvalidArgumentException("Invalid plan_id null");
        }
        try {
            $plan = new SubscriptionsPlanActivate($plan_id);
            $plan->setParams([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'Content-Type' => 'application/json',
                ],
            ]);
            return $this->client->execute($plan)->getStatusCode() == 204 ? 'success' : 'error';
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function PlansDeactivate($plan_id)
    {
        if (empty($plan_id)) {
            throw new InvalidArgumentException("Invalid plan_id null");
        }
        try {
            $plan = new SubscriptionsPlanDeactivate($plan_id);
            $plan->setParams([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'Content-Type' => 'application/json',
                ],
            ]);
            return $this->client->execute($plan)->getStatusCode() == 204 ? 'success' : 'error';
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function PlansPrice($plan_id, array $data)
    {
        if (empty($plan_id)) {
            throw new InvalidArgumentException("plan_id null");
        }
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data array");
        }
        try {
            $plan = new SubscriptionsPlanUpdatePrice($plan_id);
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
            $plan->setParams($params);
            return $this->client->execute($plan)->getStatusCode() == 204 ? 'success' : 'error';
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function SubscriptionCreate($data)
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data array");
        }
        try {
            $subscription = new SubscriptionsCreate();
            $subscription->setParams([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    'PayPal-Request-Id' => 'SUBSCRIPTION-21092019-001'
                ],
                'json' => $data
            ]);
            return json_decode($this->client->execute($subscription)->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function SubscriptionList($subscription_id, $start_time, $end_time)
    {
        if (empty($subscription_id)) {
            throw new InvalidArgumentException("Invalid subscription_id null");
        }
        if (empty($start_time)) {
            throw new InvalidArgumentException("Invalid start_time null");
        }
        if (empty($end_time)) {
            throw new InvalidArgumentException("Invalid end_time null");
        }
        try {
            $subscription = new SubscriptionsList($subscription_id, $start_time, $end_time);
            $subscription->setParams([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                ],
            ]);
            return json_decode($this->client->execute($subscription)->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function SubscriptionUpdate($subscription_id, array $data)
    {
        if (empty($subscription_id)) {
            throw new InvalidArgumentException("Invalid subscription_id null");
        }
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data array");
        }
        try {
            $subscription = new SubscriptionsUpdate($subscription_id);
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
            $subscription->setParams($params);
            return $this->client->execute($subscription)->getStatusCode() == 204 ? 'success' : 'error';
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function SubscriptionDetail($subscription_id)
    {
        if (empty($subscription_id)) {
            throw new InvalidArgumentException("Invalid subscription_id null");
        }
        try {
            $subscription = new SubscriptionsDetail($subscription_id);
            $subscription->setParams([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                ],
            ]);
            return json_decode($this->client->execute($subscription)->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function SubscriptionActivate($subscription_id, array $data)
    {
        if (empty($subscription_id)) {
            throw new InvalidArgumentException("Invalid subscription_id null");
        }
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data array");
        }
        try {
            $subscription = new SubscriptionsActivate($subscription_id);
            $subscription->setParams([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                ],
                'json' => $data
            ]);
            return $this->client->execute($subscription)->getStatusCode() == 204 ? 'success' : 'error';
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function SubscriptionCapture($subscription_id, array $data)
    {
        if (empty($subscription_id)) {
            throw new InvalidArgumentException("Invalid subscription_id null");
        }
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data array");
        }
        try {
            $subscription = new SubscriptionsCapture($subscription_id);
            $subscription->setParams([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                    "PayPal-Request-Id" => "CAPTURE-160919-A0051"
                ],
                'json' => $data
            ]);
            return $this->client->execute($subscription)->getStatusCode() == 202 ? 'success' : 'error';
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function SubscriptionRevise($subscription_id, array $data)
    {
        if (empty($subscription_id)) {
            throw new InvalidArgumentException("Invalid subscription_id null");
        }
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data array");
        }
        try {
            $subscription = new SubscriptionsRevise($subscription_id);
            $subscription->setParams([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                ],
                'json' => $data
            ]);
            return json_decode($this->client->execute($subscription)->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function SubscriptionSuspend($subscription_id, array $data)
    {
        if (empty($subscription_id)) {
            throw new InvalidArgumentException("Invalid subscription_id null");
        }
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data array");
        }
        try {
            $subscription = new SubscriptionsSuspend($subscription_id);
            $subscription->setParams([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                ],
                'json' => $data
            ]);
            return $this->client->execute($subscription)->getStatusCode() == 204 ? 'success' : 'error';
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function SubscriptionCancel($subscription_id, array $data)
    {
        if (empty($subscription_id)) {
            throw new InvalidArgumentException("Invalid subscription_id null");
        }
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid data array");
        }
        try {
            $subscription = new SubscriptionsCancel($subscription_id);
            $subscription->setParams([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
                ],
                'json' => $data
            ]);
            return $this->client->execute($subscription)->getStatusCode() == 204 ? 'success' : 'error';
        } catch (\Exception $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}