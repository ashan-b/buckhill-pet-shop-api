<?php

namespace Ashan\CurrencyExchangeRate\Tests\Unit;
use Ashan\CurrencyExchangeRate\Controllers\CurrencyExchangeRateController;
use Tests\TestCase;

class GetReferenceRateXmlTest extends TestCase
{
    /**
     * A basic test example.
     * @return void
     */
    public function test_get_reference_rate_xml()
    {
        $controller = new CurrencyExchangeRateController();
        $xml = $controller->getReferenceRateXml();

        $this->assertInstanceOf(\SimpleXMLElement::class,$xml);
    }
}
