<?php

namespace Szwtdl\Paypal;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Paypal::class, function () {
            //client_id, $client_key, $mode = 'prod'
            return new Paypal(config('services.paypal.client_id'), config('services.paypal.client_key'), config('services.paypal.mode'));
        });

        $this->app->alias(Paypal::class, 'paypal');
    }

    public function provides()
    {
        return [Paypal::class, 'paypal'];
    }

}