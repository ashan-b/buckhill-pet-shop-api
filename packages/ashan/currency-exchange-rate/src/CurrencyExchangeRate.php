<?php

namespace Ashan\CurrencyExchangeRate;

use http\Env\Response;

class CurrencyExchangeRate
{
    public static function event(float $amount, string $foreignCurrency)
    {
        try {
            if ($amount <= 0.0) {
                return response()->json(
                    [
                        'success' => 0,
                        'data' => [],
                        "error" => "Amount must be greater than 0.",
                        "errors" => [],
                        "trace" => []
                    ],
                    422
                );
            }

            $baseCurrency = config('currency_exchange_rate.base_currency', 'EUR');
            $referenceRateXmlUrl = config(
                'currency_exchange_rate.reference_rate_xml_url',
                'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml'
            );
            $originalAmount = $amount;

            $url = file_get_contents($referenceRateXmlUrl);
            $xml = new \SimpleXMLElement($url);

            $foreignCurrencyNode = $xml->xpath('//*[@currency="' . $foreignCurrency . '"]');

            if ($foreignCurrencyNode == null) {
                return response()->json(
                    [
                        'success' => 0,
                        'data' => [],
                        "error" => "Invalid foreign currency code.",
                        "errors" => [],
                        "trace" => []
                    ],
                    422
                );
            }
            $exchangeRateResponse = [];
            $foreignCurrencyRate = $foreignCurrencyNode[0]['rate'];
            $exchangeRateResponse[] = [
                "1 EUR" => $foreignCurrencyRate . " " . $foreignCurrency
            ];

            if ($baseCurrency !== "EUR") {
                $baseCurrencyNode = $xml->xpath('//*[@currency="' . $baseCurrency . '"]');
                if ($baseCurrencyNode == null) {
                    return response()->json(
                        [
                            'success' => 0,
                            'data' => [],
                            "error" => "Invalid base currency code.",
                            "errors" => [],
                            "trace" => []
                        ],
                        422
                    );
                }
                //Convert amount to EUR
                $amount = $amount / $baseCurrencyNode[0]['rate'];
                $exchangeRateResponse[] = [
                    "1 EUR" => $baseCurrencyNode[0]['rate'] . " " . $baseCurrency
                ];
            }

            $convertedAmount = round($amount * $foreignCurrencyRate, 2);


            return response()->json(
                [
                    'success' => 1,
                    'data' => [
                        'base_currency' => $baseCurrency,
                        "foreign_currency" => $foreignCurrency,
                        'exchange_rate' => $exchangeRateResponse,
                        'original_amount' => $originalAmount,
                        'converted_amount' => $convertedAmount
                    ],
                    "error" => null,
                    "errors" => [],
                    "extra" => []
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => 0,
                    'data' => [],
                    "error" => $e->getMessage(),
                    "errors" => [],
                    "trace" => []
                ],
                500
            );
        }
    }
}
