<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Invoice\AbstractInvoiceData;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractInvoiceDataTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class AbstractInvoiceDataTest extends TestCase
{
    public function testValidAbstractInvoiceData(): void
    {
        $class = new Class extends AbstractInvoiceData
        {
            protected function fields(): array
            {
                return [
                    true,
                    true,
                ];
            }
        };

        $this->assertSame(true, $class->valid());
    }

    public function testValidAbstractInvoiceDataException(): void
    {
        $class = new Class extends AbstractInvoiceData
        {
            protected function fields(): array
            {
                return [
                    true,
                    false,
                ];
            }
        };

        $this->expectException(\LogicException::class);
        $class->valid(true);
    }
}
