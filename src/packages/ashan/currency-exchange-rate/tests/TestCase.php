<?php

namespace Ashan\CurrencyExchangeRate\Tests;

use Ashan\CurrencyExchangeRate\CurrencyExchangeRateServiceProvider;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            CurrencyExchangeRateServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
