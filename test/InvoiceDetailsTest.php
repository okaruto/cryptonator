<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Invoice\Details;
use Okaruto\Cryptonator\Values\InvoiceCurrencyValue;
use Okaruto\Cryptonator\Values\InvoiceStatusValue;
use PHPUnit\Framework\TestCase;

/**
 * Class InvoiceDetailsTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class InvoiceDetailsTest extends TestCase
{
    public function testDetails(): void
    {
        $details = new Details(
            'ffa6706ff2127a749973072756f83c53',
            13.37,
            new InvoiceCurrencyValue('usd'),
            new InvoiceStatusValue('unpaid'),
            'https://www.cryptonator.com/merchant/invoice/ffa6706ff2127a749973072756f83c53'
        );

        $this->assertSame(true, $details->valid());
        $this->assertSame('ffa6706ff2127a749973072756f83c53', $details->identifier());
        $this->assertSame(13.37, $details->amount());
        $this->assertSame('usd', $details->currency());
        $this->assertSame('unpaid', $details->status());
        $this->assertSame(
            'https://www.cryptonator.com/merchant/invoice/ffa6706ff2127a749973072756f83c53',
            $details->url()
        );
    }
}
