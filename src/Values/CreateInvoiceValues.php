<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

/**
 * Class CreateInvoiceValues
 *
 * @package Okaruto\Cryptonator\Endpoint\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class CreateInvoiceValues extends AbstractValues
{
    protected const MANDATORY_KEYS = [
        self::VALUE_ITEM_NAME,
        self::VALUE_CHECKOUT_CURRENCY,
        self::VALUE_INVOICE_AMOUNT,
        self::VALUE_INVOICE_CURRENCY,
    ];

    protected const EXPORT_KEYS = [
        self::VALUE_ITEM_NAME,
        self::VALUE_ORDER_ID,
        self::VALUE_ITEM_DESCRIPTION,
        self::VALUE_CHECKOUT_CURRENCY,
        self::VALUE_INVOICE_AMOUNT,
        self::VALUE_INVOICE_CURRENCY,
        self::VALUE_SUCCESS_URL,
        self::VALUE_FAILED_URL,
        self::VALUE_CONFIRMATION_POLICY,
        self::VALUE_LANGUAGE,
    ];

    /**
     * Validate values
     *
     * @return bool
     */
    protected function validate(): bool
    {
        $checkoutCurrency = parent::get(self::VALUE_CHECKOUT_CURRENCY);
        $invoiceCurrency = parent::get(self::VALUE_INVOICE_CURRENCY);
        $confirmationPolicy = parent::get(self::VALUE_CONFIRMATION_POLICY);
        $language = parent::get(self::VALUE_LANGUAGE);

        return (new ReducedValues(
            [
                is_string(parent::get(self::VALUE_ITEM_NAME)),
                is_string(parent::get(self::VALUE_ORDER_ID, '')),
                is_string(parent::get(self::VALUE_ITEM_DESCRIPTION, '')),
                ($checkoutCurrency instanceof CheckoutCurrencyValue && $checkoutCurrency->valid()),
                is_numeric(parent::get(self::VALUE_INVOICE_AMOUNT)),
                ($invoiceCurrency instanceof InvoiceCurrencyValue && $invoiceCurrency->valid()),
                is_string(parent::get(self::VALUE_SUCCESS_URL, '')),
                is_string(parent::get(self::VALUE_FAILED_URL, '')),
                ($confirmationPolicy === null
                    || ($confirmationPolicy instanceof ConfirmationPolicyValue && $confirmationPolicy->valid())),
                ($language === null || ($language instanceof LanguageValue && $language->valid())),
            ]
        ))->valid();
    }
}
