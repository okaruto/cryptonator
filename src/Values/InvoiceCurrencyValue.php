<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

/**
 * Class InvoiceCurrencyValue
 *
 * @package Okaruto\Cryptonator\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class InvoiceCurrencyValue extends AbstractValue
{
    public const INVOICE_CURRENCY_USD = 'usd';
    public const INVOICE_CURRENCY_EUR = 'eur';
    public const INVOICE_CURRENCY_RUR = 'rur';

    protected const ALLOWED_VALUES = [
        self::INVOICE_CURRENCY_USD,
        self::INVOICE_CURRENCY_EUR,
        self::INVOICE_CURRENCY_RUR,
    ];
}
