<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\ValuesInvalidException;
use Okaruto\Cryptonator\Values\InvoiceCurrencyValue;
use Okaruto\Cryptonator\Values\StartPaymentValues;
use PHPUnit\Framework\TestCase;

/**
 * Class StartPaymentValuesTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class ValuesStartPaymentValuesTest extends TestCase
{
    public function testStartPaymentValuesMinimum(): void
    {
        $values = new StartPaymentValues(
            [
                StartPaymentValues::VALUE_ITEM_NAME => 'some random name',
                StartPaymentValues::VALUE_INVOICE_AMOUNT => 13.37,
                StartPaymentValues::VALUE_INVOICE_CURRENCY => new InvoiceCurrencyValue('usd'),
            ]
        );

        $this->assertSame(
            [
                'item_name' => 'some random name',
                'order_id' => '',
                'item_description' => '',
                'invoice_amount' => 13.37,
                'invoice_currency' => 'usd',
                'success_url' => '',
                'failed_url' => '',
                'language' => '',
            ],
            $values->array()
        );
    }

    public function testStartPaymentValuesFull(): void
    {
        $values = new StartPaymentValues(
            [
                StartPaymentValues::VALUE_ITEM_NAME => 'some random name',
                StartPaymentValues::VALUE_INVOICE_AMOUNT => 13.37,
                StartPaymentValues::VALUE_INVOICE_CURRENCY => new InvoiceCurrencyValue('usd'),
                StartPaymentValues::VALUE_ORDER_ID => 'my-order-id',
                StartPaymentValues::VALUE_ITEM_DESCRIPTION => 'some random description',
                StartPaymentValues::VALUE_SUCCESS_URL => 'https://sucess.url/page',
                StartPaymentValues::VALUE_FAILED_URL => 'https://faild.url/page',
                StartPaymentValues::VALUE_LANGUAGE => 'en',
            ]
        );

        $this->assertSame(
            [
                'item_name' => 'some random name',
                'order_id' => 'my-order-id',
                'item_description' => 'some random description',
                'invoice_amount' => 13.37,
                'invoice_currency' => 'usd',
                'success_url' => 'https://sucess.url/page',
                'failed_url' => 'https://faild.url/page',
                'language' => 'en',
            ],
            $values->array()
        );
    }

    public function testStartPaymentValuesMissing(): void
    {
        $values = new StartPaymentValues([
            StartPaymentValues::VALUE_ITEM_NAME => 'some random name',
            StartPaymentValues::VALUE_INVOICE_AMOUNT => 13.37,
            // Invoice currency missing
        ]);

        $this->expectException(ValuesInvalidException::class);
        $values->array();
    }

    public function testStartPaymentValuesInvalid(): void
    {
        $values = new StartPaymentValues(
            [
                StartPaymentValues::VALUE_ITEM_NAME => 12345,
                StartPaymentValues::VALUE_INVOICE_AMOUNT => 'one thousand',
                StartPaymentValues::VALUE_INVOICE_CURRENCY => new InvoiceCurrencyValue('cad'),
                StartPaymentValues::VALUE_ORDER_ID => 12345,
                StartPaymentValues::VALUE_ITEM_DESCRIPTION => 12345,
                StartPaymentValues::VALUE_SUCCESS_URL => 12345,
                StartPaymentValues::VALUE_FAILED_URL => 12345,
                StartPaymentValues::VALUE_LANGUAGE => 'it',
            ]
        );

        $this->expectException(ValuesInvalidException::class);
        $values->array();
    }
}
