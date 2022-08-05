<?php

namespace Ashan\CurrencyExchangeRate;

use Illuminate\Support\ServiceProvider;

class CurrencyExchangeRateServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->publishes(
            [__DIR__ . '/../config/currency_exchange_rate.php' => config_path('currency_exchange_rate.php'),]
        );
    }
}
