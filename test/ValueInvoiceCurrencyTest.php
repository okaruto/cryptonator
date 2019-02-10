<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\ValueInvalidException;
use Okaruto\Cryptonator\Values\InvoiceCurrencyValue;
use PHPUnit\Framework\TestCase;

/**
 * Class ValueInvoiceCurrencyTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class ValueInvoiceCurrencyTest extends TestCase
{
    public function testValidInvoiceCurrencyValues(): void
    {
        $value = new InvoiceCurrencyValue(InvoiceCurrencyValue::INVOICE_CURRENCY_USD);
        $this->assertSame(true, $value->valid());
        $this->assertSame('usd', $value->value());

        $value = new InvoiceCurrencyValue(InvoiceCurrencyValue::INVOICE_CURRENCY_EUR);
        $this->assertSame(true, $value->valid());
        $this->assertSame('eur', $value->value());

        $value = new InvoiceCurrencyValue(InvoiceCurrencyValue::INVOICE_CURRENCY_RUR);
        $this->assertSame(true, $value->valid());
        $this->assertSame('rur', $value->value());
    }

    public function testInvalidInvoiceCurrencyValue(): void
    {
        $value = new InvoiceCurrencyValue('yen');

        $this->assertSame(false, $value->valid());
        $this->expectException(ValueInvalidException::class);
        $value->value();
    }
}
