<?php

namespace Ashan\CurrencyExchangeRate\Tests\Feature;

use Ashan\CurrencyExchangeRate\Controllers\CurrencyExchangeRateController;
use Tests\TestCase;

class ConvertTest extends TestCase
{
    /**
     * A basic test example.
     * @return void
     */
    public function test_convert_from_usd_to_sgd()
    {
        $response = $this->getJson(
            config(
                'currency_exchange_rate.api_url',
                '/currency-exchange'
            ) . '?amount=100&base_currency=USD&currency=SGD'
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'data' => [
                        'from_currency',
                        'to_currency',
                        'original_amount',
                        'converted_amount',
                        'exchange_rate' => [
                            [
                                '1 EUR',
                                '1 EUR'
                            ]
                        ]
                    ]
                ]
            )
            ->assertJson(
                [
                    'success' => true,
                    'data' => [
                        "from_currency" => "USD",
                        "to_currency" => "SGD",
                        "original_amount" => 100
                    ]
                ]
            );
    }

    public function test_convert_to_same_currency()
    {
        $response = $this->getJson(
            config(
                'currency_exchange_rate.api_url',
                '/currency-exchange'
            ) . '?amount=100&base_currency=USD&currency=USD'
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'data' => [
                        'from_currency',
                        'to_currency',
                        'original_amount',
                        'converted_amount',
                        'exchange_rate' => [
                            [
                                '1 EUR',
                                '1 EUR'
                            ]
                        ]
                    ]
                ]
            )
            ->assertJson(
                [
                    'success' => true,
                    'data' => [
                        "from_currency" => "USD",
                        "to_currency" => "USD",
                        "original_amount" => 100,
                        "converted_amount" => 100
                    ]
                ]
            );
    }
}
