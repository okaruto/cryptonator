# Okaruto/Cryptonator

Okaruto/Cryptonator is an alternative implementation of the
[Cryptonator.com Merchant API SDK](https://github.com/cryptonator/merchant-api-sdk-php). All API methods needed to use the [Payment API](https://cryptonator.zendesk.com/hc/en-us) are implemented.

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)
[![Build Status](https://travis-ci.com/okaruto/cryptonator.svg?branch=master)](https://travis-ci.com/okaruto/cryptonator) 
[![Coverage Status](https://coveralls.io/repos/github/okaruto/cryptonator/badge.svg?branch=master)](https://coveralls.io/github/okaruto/cryptonator?branch=master)

## Installation

Just require it with composer:

```bash
composer require okaruto/cryptonator
```

## Usage

To get the MerchantApi instance:

````php
$merchantApi = new Okaruto\Cryptonator\MerchantApi(
    new GuzzleHttp\Client(), // Guzzle HTTP client instance
    'merchant id',           // Cryptonator merchant id
    'merchant secret'        // Cryptonator merchant secret 
);
````

Following methods are available:

Get a list of your invoices

````php
$merchantApi->listInvoices(
    ?string $invoiceStatus,   // Filter by invoice status, @see Okaruto\Cryptonator\Values\InvoiceStatusValue
    ?string $invoiceCurrency, // Filter by invoice currency, @see Okaruto\Cryptonator\Values\InvoiceCurrencyValue
    ?string $checkoutCurrency // Filter by cryptocurrency, @see Okaruto\Cryptonator\Values\CheckoutCurrencyValue
): InvoiceCollection
````

Get a single invoice (only partial details)

````php
$merchantApi->getInvoice(
    string $invoiceId // Cryptonator invoice id
): Invoice
````

Create a new invoice (all details)

````php
$merchantApi->createInvoice(
    string $itemName,            // Your item name
    string $checkoutCurrency,    // Checkout cryptocurrency, @see Okaruto\Cryptonator\Values\CheckoutCurrencyValue
    float $invoiceAmount,        // Invoice amount
    string $invoiceCurrency,     // Invoice currency, @see Okaruto\Cryptonator\Values\InvoiceCurrencyValue
    ?string $orderId,            // Your order id
    ?string $itemDescription,    // Item description
    ?string $successUrl,         // Success URL to redirect user
    ?string $failedUrl,          // Failure URL to redirect user
    ?string $confirmationPolicy, // Confirmation policy, @see Okaruto\Cryptonator\Values\ConfirmationPolicyValue
    ?string $language            // Checkout language, @see Okaruto\Cryptonator\Values\LanguageValue 
): Invoice
````

Create an URL to redirect the customer for payment over cryptonator checkout page

````php
$merchantApi->startPayment(
    string $itemName,         // Your item name
    float $invoiceAmount,     // Invoice amount
    string $invoiceCurrency,  // Invoice currency, @see Okaruto\Cryptonator\Values\InvoiceCurrencyValue
    ?string $orderId,         // Your order id
    ?string $itemDescription, // Item description
    ?string $successUrl,      // Success URL to redirect user
    ?string $failedUrl,       // Failure URL to redirect user
    ?string $language         // Checkout language, @see Okaruto\Cryptonator\Values\LanguageValue 
): string
````

Create an invoice out of a HTTP notification
````php
$merchantApi->httpNotificationInvoice(
    array $data // Post values of HTTP Notification
): string
````

## License

Okaruto/Cryptonator is licensed under the [MIT license](https://opensource.org/licenses/MIT).
