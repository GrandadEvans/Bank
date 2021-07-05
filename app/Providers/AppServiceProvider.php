<?php

namespace Bank\Providers;

use Bank\Observers\ProviderObserver;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->givePaymentMethodViewsSomePaymentMethods();
        Provider::observe(ProviderObserver::class);
    }

    /**
     * Whenever we call the payment method view partial, give it the list of payment methods
     */
    public function givePaymentMethodViewsSomePaymentMethods()
    {
        view()->composer('partials.form_fields._payment_type', function($view) {
            $view->with('payment_methods', PaymentMethod::all());
        });
    }
}
