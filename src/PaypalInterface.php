<?php

namespace Szwtdl\Paypal;

interface PaypalInterface
{
    public function ProductCreate($name, $description, $type, $category, $image_url, $home_url);

    public function ProductList($offset, $limit);

    public function ProductDetail($product_id);

    public function ProductUpdate($product_id, array $data);

    public function PlansList($product_id, $page, $limit, $total_required = true);

    public function PlansCreate($product_id, array $data);

    public function PlansUpdate($plan_id, $data);

    public function PlansUpdatePrice($plan_id, array $data);

    public function PlansDetail($plan_id);

    public function SubscriptionList($plan_id, $start_time, $end_time);

    public function SubscriptionCreate($plan_id, array $data);

    public function SubscriptionUpdate($subscription_id, array $data);

    public function SubscriptionDetail($subscription_id);

    public function SubscriptionActivate($subscription_id, array $data);

    public function SubscriptionCapture($subscription_id, array $data);

    public function SubscriptionRevise($subscription_id, array $data);

    public function SubscriptionSuspend($subscription_id, array $data);

}