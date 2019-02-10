<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Invoice\Dates;
use PHPUnit\Framework\TestCase;

/**
 * Class InvoiceDetailsTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class InvoiceDatesTest extends TestCase
{
    public function testDetails(): void
    {
        $dates = new Dates(
            1539792598,
            1539794398,
            1539794403
        );

        $this->assertSame(true, $dates->valid());

        $this->assertEquals(
            new \DateTimeImmutable(date(DATE_ATOM, 1539792598)),
            $dates->created()
        );

        $this->assertEquals(
            new \DateTimeImmutable(date(DATE_ATOM, 1539794398)),
            $dates->expires()
        );

        $this->assertEquals(
            new \DateTimeImmutable(date(DATE_ATOM, 1539794403)),
            $dates->dateTime()
        );
    }
}
