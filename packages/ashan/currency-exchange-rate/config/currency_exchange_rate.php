<?php

return [
    'base_currency' => env('CURRENCY_EXCHANGE_BASE_CURRENCY', 'EUR'),
    'reference_rate_xml_url' => env('CURRENCY_EXCHANGE_REFERENCE_RATE_XML_URL', 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml')
];
