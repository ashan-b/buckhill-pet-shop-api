# Currency Exchange Rate Package

## User story

As an international user I would like to know the price of a particular product or the total cart amount in the currency of my preference.

## Package Details

this package will expose an API GET endpoint that will recieve the following parameters:

 - Amount (Required)
	 - Parameter Name: amount - float
 - Currency To Exchange (Required)
	 - Parameter Name:  currency
 - Base Currency (Default: EUR)
	 - Parameter Name:  base_currency

## Config

Use vendor publish command to publish the config file.

    php artisan vendor:publish
It will be published to config/currency_exchange_rate.php

You can change following parameters from the config file or the env file.
 
 - base_currency
	 - Default: EUR
	 - ENV: CURRENCY_EXCHANGE_BASE_CURRENCY
 - reference_rate_xml_url
	 - Default: https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml
	 - ENV: CURRENCY_EXCHANGE_REFERENCE_RATE_XML_URL
 - api_url
	 - /currency-exchange
	 - ENV: CURRENCY_EXCHANGE_URL

## Testing

Package includes following tests.

 - **Unit Test**
	 - get_reference_rate_xml
 - **Feature Test**
	 - test_convert_from_usd_to_sgd
	 - test_convert_to_same_currency

Tests can be directly executed through the following command from main project.

    php artisan test

## Extra

The base currency is dynamic. You can define it in env file or you can pass the "base_currency" paramater to change it on the fly.

## Swagger
Swagger doc is included in the following link.
[{APP_URL}/api/documentation/](http://127.0.0.1:8000/api/documentation/)

-------------------
Copyright © 2022 Ashan Beruwalage - Developed with ♥
