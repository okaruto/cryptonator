<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\ValuesInvalidException;
use Okaruto\Cryptonator\Values\CheckoutCurrencyValue;
use Okaruto\Cryptonator\Values\ConfirmationPolicyValue;
use Okaruto\Cryptonator\Values\CreateInvoiceValues;
use Okaruto\Cryptonator\Values\InvoiceCurrencyValue;
use Okaruto\Cryptonator\Values\LanguageValue;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateInvoiceValuesTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class ValuesCreateInvoiceValuesTest extends TestCase
{
    public function testCreateInvoiceValuesMinimum(): void
    {
        $values = new CreateInvoiceValues(
            [
                CreateInvoiceValues::VALUE_ITEM_NAME => 'some random name',
                CreateInvoiceValues::VALUE_CHECKOUT_CURRENCY => new CheckoutCurrencyValue('bitcoin'),
                CreateInvoiceValues::VALUE_INVOICE_AMOUNT => 13.37,
                CreateInvoiceValues::VALUE_INVOICE_CURRENCY =>  new InvoiceCurrencyValue('usd'),
            ]
        );

        $this->assertSame(
            [
                'item_name' => 'some random name',
                'order_id' => '',
                'item_description' => '',
                'checkout_currency' => 'bitcoin',
                'invoice_amount' => 13.37,
                'invoice_currency' => 'usd',
                'success_url' => '',
                'failed_url' => '',
                'confirmation_policy' => '',
                'language' => '',
            ],
            $values->array()
        );
    }

    public function testCreateInvoiceValuesFull(): void
    {
        $values = new CreateInvoiceValues(
            [
                CreateInvoiceValues::VALUE_ITEM_NAME => 'some random name',
                CreateInvoiceValues::VALUE_CHECKOUT_CURRENCY => new CheckoutCurrencyValue('dash'),
                CreateInvoiceValues::VALUE_INVOICE_AMOUNT => 13.37,
                CreateInvoiceValues::VALUE_INVOICE_CURRENCY => new InvoiceCurrencyValue('usd'),
                CreateInvoiceValues::VALUE_ORDER_ID => 'my-order-id',
                CreateInvoiceValues::VALUE_ITEM_DESCRIPTION => 'some random description',
                CreateInvoiceValues::VALUE_SUCCESS_URL => 'https://sucess.url/page',
                CreateInvoiceValues::VALUE_FAILED_URL => 'https://faild.url/page',
                CreateInvoiceValues::VALUE_CONFIRMATION_POLICY => new ConfirmationPolicyValue('3'),
                CreateInvoiceValues::VALUE_LANGUAGE => new LanguageValue('en'),
            ]
        );

        $this->assertSame(
            [
                'item_name' => 'some random name',
                'order_id' => 'my-order-id',
                'item_description' => 'some random description',
                'checkout_currency' => 'dash',
                'invoice_amount' => 13.37,
                'invoice_currency' => 'usd',
                'success_url' => 'https://sucess.url/page',
                'failed_url' => 'https://faild.url/page',
                'confirmation_policy' => '3',
                'language' => 'en',
            ],
            $values->array()
        );
    }

    public function testCreateInvoiceValuesMissing(): void
    {
        $values = new CreateInvoiceValues([
            CreateInvoiceValues::VALUE_ITEM_NAME => 'some random name',
            CreateInvoiceValues::VALUE_CHECKOUT_CURRENCY => new CheckoutCurrencyValue('bitcoin'),
            CreateInvoiceValues::VALUE_INVOICE_AMOUNT => 13.37,
            // Invoice currency missing
        ]);

        $this->expectException(ValuesInvalidException::class);
        $values->array();
    }

    public function testCreateInvoiceValuesInvalid(): void
    {
        $values = new CreateInvoiceValues(
            [
                CreateInvoiceValues::VALUE_ITEM_NAME => 12345,
                CreateInvoiceValues::VALUE_CHECKOUT_CURRENCY => new CheckoutCurrencyValue('obscurecryptocurrency'),
                CreateInvoiceValues::VALUE_INVOICE_AMOUNT => 'one thousand',
                CreateInvoiceValues::VALUE_INVOICE_CURRENCY => new InvoiceCurrencyValue('cad'),
                CreateInvoiceValues::VALUE_ORDER_ID => 12345,
                CreateInvoiceValues::VALUE_ITEM_DESCRIPTION => 12345,
                CreateInvoiceValues::VALUE_SUCCESS_URL => 12345,
                CreateInvoiceValues::VALUE_FAILED_URL => 12345,
                CreateInvoiceValues::VALUE_CONFIRMATION_POLICY => 'fast',
                CreateInvoiceValues::VALUE_LANGUAGE => 'it',
            ]
        );

        $this->expectException(ValuesInvalidException::class);
        $values->array();
    }
}
