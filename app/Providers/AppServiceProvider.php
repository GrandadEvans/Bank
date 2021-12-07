<?php

namespace Bank\Providers;

//use Bank\Models\Transaction;
use Bank\Observers\ProviderObserver;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
//use Bank\Observers\TransactionObserver;
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
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

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

        // TransactionObserver has been disabled. Please see the file itself for explanation
        // Transaction::observe(TransactionObserver::class);
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
