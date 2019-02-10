<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

/**
 * Class StartPaymentValues
 *
 * @package Okaruto\Cryptonator\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class StartPaymentValues extends AbstractValues
{
    protected const MANDATORY_KEYS = [
        self::VALUE_ITEM_NAME,
        self::VALUE_INVOICE_AMOUNT,
        self::VALUE_INVOICE_CURRENCY,
    ];

    protected const EXPORT_KEYS = [
        self::VALUE_ITEM_NAME,
        self::VALUE_ORDER_ID,
        self::VALUE_ITEM_DESCRIPTION,
        self::VALUE_INVOICE_AMOUNT,
        self::VALUE_INVOICE_CURRENCY,
        self::VALUE_SUCCESS_URL,
        self::VALUE_FAILED_URL,
        self::VALUE_LANGUAGE,
    ];

    /**
     * Validate values
     *
     * @return bool
     */
    protected function validate(): bool
    {
        $invoiceCurrency = parent::get(self::VALUE_INVOICE_CURRENCY);

        return array_reduce(
            [
                is_string(parent::get(self::VALUE_ITEM_NAME)),
                is_string(parent::get(self::VALUE_ORDER_ID, '')),
                is_string(parent::get(self::VALUE_ITEM_DESCRIPTION, '')),
                is_numeric(parent::get(self::VALUE_INVOICE_AMOUNT)),
                ($invoiceCurrency instanceof InvoiceCurrencyValue && $invoiceCurrency->valid()),
                is_string(parent::get(self::VALUE_SUCCESS_URL, '')),
                is_string(parent::get(self::VALUE_FAILED_URL, '')),
                is_string(parent::get(self::VALUE_LANGUAGE, '')),
            ],
            function (bool $carry, bool $value): bool {
                return $carry && $value;
            },
            true
        );
    }
}
