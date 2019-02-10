<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Invoice\Checkout;
use Okaruto\Cryptonator\Values\CheckoutCurrencyValue;
use PHPUnit\Framework\TestCase;

/**
 * Class InvoiceCheckoutTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class InvoiceCheckoutTest extends TestCase
{
    public function testCheckout(): void
    {
        $checkout = new Checkout(
            '19u4RU9H8kcv3oPapNqSkk3GKGNvRrvkst',
            0.002082833526,
            new CheckoutCurrencyValue('dash')
        );

        $this->assertSame(true, $checkout->valid());
        $this->assertSame('19u4RU9H8kcv3oPapNqSkk3GKGNvRrvkst', $checkout->address());
        $this->assertSame(0.002082833526, $checkout->amount());
        $this->assertSame('dash', $checkout->currency());
    }
}
