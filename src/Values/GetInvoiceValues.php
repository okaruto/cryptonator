<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

/**
 * Class GetInvoiceValues
 *
 * @package Okaruto\Cryptonator\Endpoint\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class GetInvoiceValues extends AbstractValues
{
    protected const MANDATORY_KEYS = [
        self::VALUE_INVOICE_ID,
    ];

    protected const EXPORT_KEYS = [
        self::VALUE_INVOICE_ID,
    ];

    /**
     * Validate values
     *
     * @return bool
     */
    protected function validate(): bool
    {
        return is_string(parent::get(self::VALUE_INVOICE_ID));
    }
}
