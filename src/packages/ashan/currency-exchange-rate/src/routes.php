<?php

Route::get(
    config('currency_exchange_rate.api_url', '/currency-exchange'),
    [
        \Ashan\CurrencyExchangeRate\Controllers\CurrencyExchangeRateController::class,
        'convert'
    ]
);


