<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\ValuesInvalidException;
use Okaruto\Cryptonator\Values\GetInvoiceValues;
use Okaruto\Cryptonator\Values\ListInvoicesValues;
use PHPUnit\Framework\TestCase;

/**
 * Class ValuesGetInvoiceValuesTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class ValuesGetInvoiceValuesTest extends TestCase
{
    public function testGetInvoiceValues(): void
    {
        $values = new GetInvoiceValues(
            [
                GetInvoiceValues::VALUE_INVOICE_ID => 'some_invoice_id',
            ]
        );

        $this->assertSame(['invoice_id' => 'some_invoice_id'], $values->array());
    }

    public function testGetInvoiceValuesSuperflous(): void
    {
        $values = new GetInvoiceValues(
            [
                ListInvoicesValues::VALUE_INVOICE_ID => 'some_invoice_id',
                'superflous' => 'value',
            ]
        );

        $this->assertSame(['invoice_id' => 'some_invoice_id'], $values->array());
    }

    public function testGetInvoiceValuesInvalid(): void
    {
        $values = new GetInvoiceValues(
            [
                GetInvoiceValues::VALUE_INVOICE_ID => 1234,
            ]
        );

        $this->expectException(ValuesInvalidException::class);
        $values->array();
    }

    public function testGetInvoiceValuesMissing(): void
    {
        $values = new GetInvoiceValues(
            [
                'not_an' => 'invoice_id',
            ]
        );

        $this->expectException(ValuesInvalidException::class);
        $values->array();
    }
}
