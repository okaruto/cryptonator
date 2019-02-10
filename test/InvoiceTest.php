<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\InvoiceInvalidException;
use Okaruto\Cryptonator\Exceptions\WrongInvoiceTypeException;
use Okaruto\Cryptonator\Invoice;
use PHPUnit\Framework\TestCase;

/**
 * Class InvoiceTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class InvoiceTest extends TestCase
{
    public function testValidFullInvoice(): void
    {
        $invoice = $this->validFullInvoice();

        $this->assertSame(false, $invoice->partial());
        $this->assertSame(true, $invoice->full());
        $this->assertSame(true, $invoice->valid());
    }

    public function testValidFullInvoiceDetails(): void
    {
        $invoice = $this->validFullInvoice();

        $this->assertInstanceOf(Invoice\DetailsInterface::class, $invoice->details());
    }

    public function testValidFullInvoiceCheckout(): void
    {
        $invoice = $this->validFullInvoice();

        $this->assertInstanceOf(Invoice\CheckoutInterface::class, $invoice->checkout());
    }

    public function testValidFullInvoiceDates(): void
    {
        $invoice = $this->validFullInvoice();

        $this->assertInstanceOf(Invoice\DatesInterface::class, $invoice->dates());
    }

    public function testValidPartialInvoice(): void
    {
        $invoice = $this->validPartialInvoice();

        $this->assertSame(false, $invoice->full());
        $this->assertSame(true, $invoice->partial());
        $this->assertSame(true, $invoice->valid());
    }

    public function testValidPartialInvoiceDetails(): void
    {
        $invoice = $this->validPartialInvoice();

        $this->assertInstanceOf(Invoice\DetailsInterface::class, $invoice->details());
    }

    public function testValidPartialInvoiceCheckoutException(): void
    {
        $invoice = $this->validPartialInvoice();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Trying access wrong invoice type: partial');
        $invoice->checkout();
    }

    public function testValidPartialInvoiceDatesException(): void
    {
        $invoice = $this->validPartialInvoice();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Trying access wrong invoice type: partial');
        $invoice->dates();
    }

    public function testInvalidFullInvoice(): void
    {
        $fullInvoice = [
            'invoice_status' => 'cancelled',
        ];

        $invoice = new Invoice($fullInvoice);

        $this->assertSame(true, $invoice->full());
        $this->assertSame(false, $invoice->valid());

        $this->expectException(InvoiceInvalidException::class);
        $invoice->orderId();
    }

    public function testInvalidPartialInvoice(): void
    {
        $partialInvoice = [
            'status' => 'cancelled',
        ];

        $invoice = new Invoice($partialInvoice);

        $this->assertSame(true, $invoice->partial());
        $this->assertSame(false, $invoice->valid());

        $this->expectException(InvoiceInvalidException::class);
        $invoice->orderId();
    }

    public function testInvoiceWrongTypeExceptionPartial(): void
    {
        $invoice = new Invoice(['non_actual_status_key' => '123456789']);

        $this->expectException(WrongInvoiceTypeException::class);
        $invoice->partial();
    }

    public function testInvoiceWrongTypeExceptionFull(): void
    {
        $invoice = new Invoice(['non_actual_status_key' => '123456789']);

        $this->expectException(WrongInvoiceTypeException::class);
        $invoice->full();
    }

    public function testInvoiceWrongTypeExceptionOrderId(): void
    {
        $invoice = new Invoice(['non_actual_status_key' => '123456789']);

        $this->expectException(WrongInvoiceTypeException::class);
        $invoice->orderId();
    }

    private function validFullInvoice(): Invoice
    {
        return new Invoice(
            [
                'invoice_id' => 'ffa6706ff2127a749973072756f83c53',
                'invoice_created' => '1539792598',
                'invoice_expires' => '1539794398',
                'invoice_amount' => '13.37',
                'invoice_currency' => 'usd',
                'invoice_status' => 'unpaid',
                'invoice_url' => 'https://www.cryptonator.com/merchant/invoice/ffa6706ff2127a749973072756f83c53',
                'order_id' => 'my-order-id',
                'checkout_address' => '19u4RU9H8kcv3oPapNqSkk3GKGNvRrvkst',
                'checkout_amount' => '0.002082833526',
                'checkout_currency' => 'bitcoin',
                'date_time' => '1539794403',
            ]
        );
    }

    private function validPartialInvoice(): Invoice
    {
        return new Invoice(
            [
                'order_id' => 'test-order-id',
                'amount' => '13.37000000',
                'currency' => 'usd',
                'status' => 'cancelled',
            ]
        );
    }
}
