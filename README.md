# Okaruto/Cryptonator

Okaruto/Cryptonator is an alternative implementation of the [Cryptonator.com Merchant API SDK](https://github.com/cryptonator/merchant-api-sdk-php). All API methods to use the [Payment API](https://cryptonator.zendesk.com/hc/en-us) are implemented.

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg?style=flat-square)](https://php.net/)

## Installation

Just require it with composer:

```bash
composer require okaruto/cryptonator
```

## Usage

To get the MerchantApi instance:

````php
$merchantApi = new Okaruto\Cryptonator\MerchantApi(
    new GuzzleHttp\Client(),
    'merchant id',
    'merchant secret'
);
````

Following methods are available:

Get a list of your invoices

````php
$merchantApi->listInvoices(
    string $invoiceStatus, // (optional) Filter by invoice status
    string $invoiceCurrency, // (optional) Filter by invoice currency 
    string $checkoutCurrency, // (optional) Filter by cryptocurrency 
): InvoiceCollection
````

Get a single invoice (only partial details)

````php
$merchantApi->getInvoice(
    string $invoiceId
): Invoice
````

Create a new invoice (all details)

````php
$merchantApi->createInvoice(
 // @TODO: Add values
): Invoice
````

Create an URL to start a payment

````php
$merchantApi->startPayment(
    // @TODO: Add values
): string
````

Create an invoice out of a HTTP notification
````php
$merchantApi->httpNotificationInvoice(
    array $data // Post values of HTTP Notification
): string
````

## License

MIT - See LICENSE file