<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\ValueInvalidException;
use Okaruto\Cryptonator\Exceptions\ValuesInvalidException;
use Okaruto\Cryptonator\Values\CheckoutCurrencyValue;
use Okaruto\Cryptonator\Values\InvoiceCurrencyValue;
use Okaruto\Cryptonator\Values\InvoiceStatusValue;
use Okaruto\Cryptonator\Values\ListInvoicesValues;
use PHPUnit\Framework\TestCase;

/**
 * Class ListInvoicesValuesTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class ValuesListInvoicesValuesTest extends TestCase
{
    public function testListInvoicesValues(): void
    {
        $values = new ListInvoicesValues(
            [
                ListInvoicesValues::VALUE_INVOICE_STATUS => new InvoiceStatusValue('unpaid'),
                ListInvoicesValues::VALUE_INVOICE_CURRENCY => new InvoiceCurrencyValue('usd'),
                ListInvoicesValues::VALUE_CHECKOUT_CURRENCY => new CheckoutCurrencyValue('bitcoin'),
            ]
        );

        $this->assertSame(
            [
                'invoice_status' => 'unpaid',
                'invoice_currency' => 'usd',
                'checkout_currency' => 'bitcoin'
            ],
            $values->array()
        );
    }

    public function testListInvoicesValuesOptional(): void
    {
        $values = new ListInvoicesValues([]);

        $this->assertSame(
            [
                'invoice_status' => '',
                'invoice_currency' => '',
                'checkout_currency' => ''
            ],
            $values->array()
        );
    }

    public function testListInvoicesValuesEmpty(): void
    {
        $values = new ListInvoicesValues(
            [
                ListInvoicesValues::VALUE_INVOICE_STATUS => '',
                ListInvoicesValues::VALUE_INVOICE_CURRENCY => '',
                ListInvoicesValues::VALUE_CHECKOUT_CURRENCY => '',
            ]
        );

        $this->assertSame(
            [
                'invoice_status' => '',
                'invoice_currency' => '',
                'checkout_currency' => ''
            ],
            $values->array()
        );
    }

    public function testListInvoicesValuesInvalidInvoiceStatus(): void
    {
        $values = new ListInvoicesValues(
            [
                ListInvoicesValues::VALUE_INVOICE_STATUS => new InvoiceStatusValue('invalidstatus'),
            ]
        );

        $this->expectException(ValueInvalidException::class);
        $values->array();
    }

    public function testListInvoicesValuesInvalidInvoiceCurrency(): void
    {
        $values = new ListInvoicesValues(
            [
                ListInvoicesValues::VALUE_INVOICE_CURRENCY => 'cad',
            ]
        );

        $this->expectException(ValuesInvalidException::class);
        $values->array();
    }

    public function testListInvoicesValuesInvalidCheckoutCurrency(): void
    {
        $values = new ListInvoicesValues(
            [
                ListInvoicesValues::VALUE_CHECKOUT_CURRENCY => 'obscurecryptocurrency',
            ]
        );

        $this->expectException(ValuesInvalidException::class);
        $values->array();
    }
}
