<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\ValueInvalidException;
use Okaruto\Cryptonator\Values\InvoiceStatusValue;
use PHPUnit\Framework\TestCase;

/**
 * Class ValueInvoiceStatusTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class ValueInvoiceStatusTest extends TestCase
{
    public function testInvalidInvoiceStatusValues(): void
    {
        $value = new InvoiceStatusValue(InvoiceStatusValue::INVOICE_STATUS_UNPAID);
        $this->assertSame(true, $value->valid());
        $this->assertSame('unpaid', $value->value());

        $value = new InvoiceStatusValue(InvoiceStatusValue::INVOICE_STATUS_MISPAID);
        $this->assertSame(true, $value->valid());
        $this->assertSame('mispaid', $value->value());

        $value = new InvoiceStatusValue(InvoiceStatusValue::INVOICE_STATUS_CONFIRMING);
        $this->assertSame(true, $value->valid());
        $this->assertSame('confirming', $value->value());

        $value = new InvoiceStatusValue(InvoiceStatusValue::INVOICE_STATUS_CANCELLED);
        $this->assertSame(true, $value->valid());
        $this->assertSame('cancelled', $value->value());

        $value = new InvoiceStatusValue(InvoiceStatusValue::INVOICE_STATUS_PAID);
        $this->assertSame(true, $value->valid());
        $this->assertSame('paid', $value->value());
    }

    public function testInvalidInvoiceStatusValue(): void
    {
        $value = new InvoiceStatusValue('wtf');

        $this->assertSame(false, $value->valid());
        $this->expectException(ValueInvalidException::class);
        $value->value();
    }
}
