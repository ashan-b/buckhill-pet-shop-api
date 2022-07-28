<?php

namespace Ashan\CurrencyExchangeRate;

use App\Http\Controllers\CurrencyExchangeRateController;
use Illuminate\Support\ServiceProvider;

class CurrencyExchangeRateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        $this->publishes(
            [
                __DIR__ . '/../config/currency_exchange_rate.php' => config_path('currency_exchange_rate.php')
            ]
        );
    }
}
