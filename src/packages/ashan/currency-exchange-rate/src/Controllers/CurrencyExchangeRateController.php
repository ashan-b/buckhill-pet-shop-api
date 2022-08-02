<?php

namespace Ashan\CurrencyExchangeRate\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Load the CURRENCY_EXCHANGE_URL from env to use it in swagger annotation
define("CURRENCY_EXCHANGE_URL", env('CURRENCY_EXCHANGE_URL', '/currency-exchange'));

class CurrencyExchangeRateController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Currency Exchange Rate - Package",
     *     description=""
     * )
     *
     * @OA\Get(
     *     path=CURRENCY_EXCHANGE_URL,
     *     summary="Convert Currency",
     *     tags={"Currency Exchange Rate - Package"},
     * @OA\Parameter(
     *     in="query",
     *     name="amount",
     *     description="Amount to be converted.",
     *     required=true,
     *     example="100"
     * ),
     *   @OA\Parameter(
     *     in="query",
     *     name="currency",
     *     description="Currency code.",
     *     required=true,
     *     example="SGD"
     * ),
     *     @OA\Parameter(
     *     in="query",
     *     name="base_currency",
     *     description="Base Currency code. Defaults to EUR.",
     *     required=false
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function convert(Request $request)
    {
        $amount = $request->get('amount', 0.0);
        $from = $request->get('base_currency', config('currency_exchange_rate.base_currency', 'EUR'));
        $to = $request->get('currency', '');

        return $this->convertCurrency($amount, $from, $to);
    }

    public function getReferenceRateXml()
    {
        $referenceRateXmlUrl = config(
            'currency_exchange_rate.reference_rate_xml_url',
            'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml'
        );
        $url = file_get_contents($referenceRateXmlUrl);
        return new \SimpleXMLElement($url);
    }

    public function convertCurrency(float $amount, string $from, string $to)
    {
        $exchangeRateResponse = [];

        $baseCurrency = $from;
        $foreignCurrency = $to;

        try {
            $xml = self::getReferenceRateXml();

            //Amount validation
            $originalAmount = $amount;

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

            //Base Currency Validation
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

            //Target Currency Validation
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
            $foreignCurrencyRate = $foreignCurrencyNode[0]['rate'];
            $exchangeRateResponse[] = [
                "1 EUR" => $foreignCurrencyRate . " " . $foreignCurrency
            ];

            $convertedAmount = round($amount * $foreignCurrencyRate, 2);

            return response()->json(
                [
                    'success' => 1,
                    'data' => [
                        'from_currency' => $baseCurrency,
                        "to_currency" => $foreignCurrency,
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
