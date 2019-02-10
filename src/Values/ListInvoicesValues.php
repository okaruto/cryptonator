<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

/**
 * Class ListInvoicesValues
 *
 * @package Okaruto\Cryptonator\Endpoint\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class ListInvoicesValues extends AbstractValues
{
    protected const MANDATORY_KEYS = [];

    protected const EXPORT_KEYS = [
        self::VALUE_INVOICE_STATUS,
        self::VALUE_INVOICE_CURRENCY,
        self::VALUE_CHECKOUT_CURRENCY,
    ];

    /**
     * Validate values
     *
     * @return bool
     */
    protected function validate(): bool
    {
        $invoiceStatus = parent::get(self::VALUE_INVOICE_STATUS, '');
        $invoiceCurrency = parent::get(self::VALUE_INVOICE_CURRENCY, '');
        $checkoutCurrency = parent::get(self::VALUE_CHECKOUT_CURRENCY, '');

        return (new ReducedValues(
            [
                ($invoiceStatus === ''
                    || ($invoiceStatus instanceof InvoiceStatusValue && $invoiceStatus->valid(true))),
                ($invoiceCurrency === ''
                    || ($invoiceCurrency instanceof InvoiceCurrencyValue && $invoiceCurrency->valid(true))),
                ($checkoutCurrency === ''
                    || ($checkoutCurrency instanceof CheckoutCurrencyValue && $checkoutCurrency->valid(true))),
            ]
        ))->valid();
    }
}
