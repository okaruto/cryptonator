<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

/**
 * Class InvoiceStatus
 *
 * @package Okaruto\Cryptonator\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class InvoiceStatusValue extends AbstractValue
{
    public const INVOICE_STATUS_UNPAID = 'unpaid';
    public const INVOICE_STATUS_PAID = 'paid';
    public const INVOICE_STATUS_CANCELLED = 'cancelled';
    public const INVOICE_STATUS_MISPAID = 'mispaid';
    public const INVOICE_STATUS_CONFIRMING = 'confirming';

    protected const ALLOWED_VALUES = [
        self::INVOICE_STATUS_UNPAID,
        self::INVOICE_STATUS_PAID,
        self::INVOICE_STATUS_CANCELLED,
        self::INVOICE_STATUS_MISPAID,
        self::INVOICE_STATUS_CONFIRMING,
    ];
}
