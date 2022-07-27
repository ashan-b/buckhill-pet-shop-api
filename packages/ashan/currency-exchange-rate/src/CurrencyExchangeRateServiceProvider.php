<?php

namespace Ashan\CurrencyExchangeRate;

use Illuminate\Support\ServiceProvider;

class CurrencyExchangeRateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/currency_exchange_rate.php' => config_path('currency_exchange_rate.php')
            ]
        );
    }

    public function register()
    {
        $this->app->singleton(
            CurrencyExchangeRate::class,
            function () {
                return new CurrencyExchangeRate();
            }
        );
    }
}
