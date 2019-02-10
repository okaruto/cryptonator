<?php

declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use GuzzleHttp\Psr7\Request;
use Okaruto\Cryptonator\Endpoint\CreateInvoice;
use Okaruto\Cryptonator\Exceptions\HashInvalidException;
use Okaruto\Cryptonator\Hash\Generator;
use Okaruto\Cryptonator\Values\CheckoutCurrencyValue;
use Okaruto\Cryptonator\Values\ConfirmationPolicyValue;
use Okaruto\Cryptonator\Values\CreateInvoiceValues;
use Okaruto\Cryptonator\Values\InvoiceCurrencyValue;
use Okaruto\Cryptonator\Values\LanguageValue;
use PHPUnit\Framework\TestCase;

class EndpointCreateInvoiceTest extends TestCase
{

    use PrepareClientTrait;

    const MERCHANT_ID = 'b60d121b438a380c343d5ec3c2037564';
    const SECRET = '0987654321fedcba';

    public function testCreateInvoice(): void
    {
        $container = [];

        $getInvoiceResponse = $this->invoiceResponse();

        $endpoint = new CreateInvoice(
            $this->client(json_encode($getInvoiceResponse), 200, $container),
            self::MERCHANT_ID,
            self::SECRET,
            new CreateInvoiceValues(
                [
                    CreateInvoiceValues::VALUE_ITEM_NAME => 'some random name',
                    CreateInvoiceValues::VALUE_CHECKOUT_CURRENCY => new CheckoutCurrencyValue('bitcoin'),
                    CreateInvoiceValues::VALUE_INVOICE_AMOUNT => 13.37,
                    CreateInvoiceValues::VALUE_INVOICE_CURRENCY => new InvoiceCurrencyValue('usd'),
                    CreateInvoiceValues::VALUE_ORDER_ID => 'my-order-id',
                    CreateInvoiceValues::VALUE_ITEM_DESCRIPTION => 'some random description',
                    CreateInvoiceValues::VALUE_SUCCESS_URL => 'https://sucess.url/page',
                    CreateInvoiceValues::VALUE_FAILED_URL => 'https://faild.url/page',
                    CreateInvoiceValues::VALUE_CONFIRMATION_POLICY => new ConfirmationPolicyValue('3'),
                    CreateInvoiceValues::VALUE_LANGUAGE => new LanguageValue('en'),
                ]
            )
        );

        $result = $endpoint->send();

        /** @var Request $request */
        $request = $container[0]['request'];

        $this->assertSame(
            [
                'scheme' => 'https',
                'host' => 'api.cryptonator.com',
                'path' => '/api/merchant/v1/createinvoice',
            ],
            parse_url((string)$request->getUri())
        );

        unset($result['date_time']);
        unset($getInvoiceResponse['secret_hash']);
        $getInvoiceResponse[CreateInvoiceValues::VALUE_ORDER_ID] = 'my-order-id';
        $getInvoiceResponse[CreateInvoiceValues::VALUE_INVOICE_AMOUNT] = '13.37';
        $getInvoiceResponse[CreateInvoiceValues::VALUE_INVOICE_CURRENCY] = 'usd';
        $getInvoiceResponse[CreateInvoiceValues::VALUE_INVOICE_STATUS] = 'unpaid';
        $getInvoiceResponse['invoice_url'] = '';

        $this->assertSame($getInvoiceResponse, $result);
    }

    public function testSecretHashMismatch(): void
    {
        $container = [];

        $getInvoiceResponse = $this->invoiceResponse();
        $getInvoiceResponse['secret_hash'] = 'abcdef1234567890abcdef1234567890abcdef12';

        $endpoint = new CreateInvoice(
            $this->client(json_encode($getInvoiceResponse), 200, $container),
            self::MERCHANT_ID,
            self::SECRET,
            new CreateInvoiceValues(
                [
                    CreateInvoiceValues::VALUE_ITEM_NAME => 'some random name',
                    CreateInvoiceValues::VALUE_CHECKOUT_CURRENCY => new CheckoutCurrencyValue('bitcoin'),
                    CreateInvoiceValues::VALUE_INVOICE_AMOUNT => 13.37,
                    CreateInvoiceValues::VALUE_INVOICE_CURRENCY => new InvoiceCurrencyValue('usd'),
                    CreateInvoiceValues::VALUE_ORDER_ID => 'my-order-id',
                    CreateInvoiceValues::VALUE_ITEM_DESCRIPTION => 'some random description',
                    CreateInvoiceValues::VALUE_SUCCESS_URL => 'https://sucess.url/page',
                    CreateInvoiceValues::VALUE_FAILED_URL => 'https://faild.url/page',
                    CreateInvoiceValues::VALUE_CONFIRMATION_POLICY => new ConfirmationPolicyValue('3'),
                    CreateInvoiceValues::VALUE_LANGUAGE => new LanguageValue('en'),
                ]
            )
        );

        $this->expectException(HashInvalidException::class);
        $endpoint->send();
    }

    private function invoiceResponse(): array
    {
        $data = [
            'invoice_id' => 'ffa6706ff2127a749973072756f83c53',
            'invoice_created' => '1539792598',
            'invoice_expires' => '1539794398',
            'checkout_address' => '19u4RU9H8kcv3oPapNqSkk3GKGNvRrvkst',
            'checkout_amount' => '0.002082833526',
            'checkout_currency' => 'bitcoin',
        ];

        $data['secret_hash'] = (new Generator(self::SECRET, $data))->hash();

        return $data;
    }
}
