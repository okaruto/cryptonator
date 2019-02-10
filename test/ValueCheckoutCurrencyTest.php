<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\ValueInvalidException;
use Okaruto\Cryptonator\Values\CheckoutCurrencyValue;
use PHPUnit\Framework\TestCase;

/**
 * Class CheckoutCurrencyValueTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class ValueCheckoutCurrencyTest extends TestCase
{
    public function testValidCheckoutCurrencies(): void
    {
        $value = new CheckoutCurrencyValue(CheckoutCurrencyValue::CHECKOUT_CURRENCY_BITCOIN);
        $this->assertSame(true, $value->valid());
        $this->assertSame('bitcoin', $value->value());

        $value = new CheckoutCurrencyValue(CheckoutCurrencyValue::CHECKOUT_CURRENCY_BITCOINCASH);
        $this->assertSame(true, $value->valid());
        $this->assertSame('bitcoincash', $value->value());

        $value = new CheckoutCurrencyValue(CheckoutCurrencyValue::CHECKOUT_CURRENCY_ETHEREUM);
        $this->assertSame(true, $value->valid());
        $this->assertSame('ethereum', $value->value());

        $value = new CheckoutCurrencyValue(CheckoutCurrencyValue::CHECKOUT_CURRENCY_ETHEREUMCLASSIC);
        $this->assertSame(true, $value->valid());
        $this->assertSame('ethereumclassic', $value->value());

        $value = new CheckoutCurrencyValue(CheckoutCurrencyValue::CHECKOUT_CURRENCY_LITECOIN);
        $this->assertSame(true, $value->valid());
        $this->assertSame('litecoin', $value->value());

        $value = new CheckoutCurrencyValue(CheckoutCurrencyValue::CHECKOUT_CURRENCY_DASH);
        $this->assertSame(true, $value->valid());
        $this->assertSame('dash', $value->value());

        $value = new CheckoutCurrencyValue(CheckoutCurrencyValue::CHECKOUT_CURRENCY_ZCASH);
        $this->assertSame(true, $value->valid());
        $this->assertSame('zcash', $value->value());

        $value = new CheckoutCurrencyValue(CheckoutCurrencyValue::CHECKOUT_CURRENCY_DOGECOIN);
        $this->assertSame(true, $value->valid());
        $this->assertSame('dogecoin', $value->value());

        $value = new CheckoutCurrencyValue(CheckoutCurrencyValue::CHECKOUT_CURRENCY_PEERCOIN);
        $this->assertSame(true, $value->valid());
        $this->assertSame('peercoin', $value->value());
    }

    public function testInvalidCheckoutCurrency(): void
    {
        $value = new CheckoutCurrencyValue('aeon');

        $this->assertSame(false, $value->valid());
        $this->expectException(ValueInvalidException::class);
        $value->value();
    }
}
