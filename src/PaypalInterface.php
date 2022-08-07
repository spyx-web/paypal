<?php

namespace Szwtdl\Paypal;

interface PaypalInterface
{
    public function ProductCreate($name, $description, $type, $category, $image_url, $home_url);

    public function ProductList($offset, $limit);

    public function ProductDetail($product_id);

    public function ProductUpdate($product_id, array $data);

    public function PlansList($product_id, $page, $limit, $total_required = true);

    public function PlansCreate($data);

    public function PlansUpdate($plan_id, $data);

    public function PlansPrice($plan_id, array $data);

    public function PlansDetail($plan_id);

    public function PlansActivate($plan_id);

    public function PlansDeactivate($plan_id);

    public function SubscriptionList($subscription_id, $start_time, $end_time);

    public function SubscriptionCreate($data);

    public function SubscriptionUpdate($subscription_id, array $data);

    public function SubscriptionDetail($subscription_id);

    public function SubscriptionActivate($subscription_id, array $data);

    public function SubscriptionCapture($subscription_id, array $data);

    public function SubscriptionRevise($subscription_id, array $data);

    public function SubscriptionSuspend($subscription_id, array $data);

    public function SubscriptionCancel($subscription_id, array $data);
}