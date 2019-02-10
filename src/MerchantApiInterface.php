<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator;

/**
 * Interface MerchantApiInterface
 *
 * @package Okaruto\Cryptonator
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
interface MerchantApiInterface
{
    /**
     * Return all invoices
     *
     * @param string|null $invoiceStatus    Invoice status
     * @param string|null $invoiceCurrency  Invoice currency
     * @param string|null $checkoutCurrency Checkout currency
     *
     * @return InvoiceCollection
     */
    public function listInvoices(
        ?string $invoiceStatus = null,
        ?string $invoiceCurrency = null,
        ?string $checkoutCurrency = null
    ): InvoiceCollection;

    /**
     * Return a specific invoice
     *
     * @param string $invoiceId Invoice id
     *
     * @return Invoice
     */
    public function getInvoice(string $invoiceId): Invoice;

    /**
     * Create a new invoice
     *
     * @param string      $itemName           Item name
     * @param string      $checkoutCurrency   Checkout cryptocurency
     * @param float       $invoiceAmount      Invoice amount
     * @param string      $invoiceCurrency    Invoice currency
     * @param null|string $orderId            Internal order id
     * @param null|string $itemDescription    Item Description
     * @param null|string $successUrl         Success url
     * @param null|string $failedUrl          Failed url
     * @param null|string $confirmationPolicy Confirmation policy
     * @param null|string $language           Language
     *
     * @return Invoice
     */
    public function createInvoice(
        string $itemName,
        string $checkoutCurrency,
        float $invoiceAmount,
        string $invoiceCurrency,
        ?string $orderId = null,
        ?string $itemDescription = null,
        ?string $successUrl = null,
        ?string $failedUrl = null,
        ?string $confirmationPolicy = null,
        ?string $language = null
    ): Invoice;

    /**
     * Create a new invoice
     *
     * @param string      $itemName        Item name
     * @param float       $invoiceAmount   Invoice amount
     * @param string      $invoiceCurrency Invoice currency
     * @param null|string $orderId         Internal order id
     * @param null|string $itemDescription Item Description
     * @param null|string $successUrl      Success url
     * @param null|string $failedUrl       Failed url
     * @param null|string $language        Language
     *
     * @return string
     */
    public function startPayment(
        string $itemName,
        float $invoiceAmount,
        string $invoiceCurrency,
        ?string $orderId = null,
        ?string $itemDescription = null,
        ?string $successUrl = null,
        ?string $failedUrl = null,
        ?string $language = null
    ): string;

    /**
     * Create an invoice from HTTP notification
     *
     * @param array $data Data from HTTP notification
     *
     * @return Invoice
     */
    public function httpNotificationInvoice(array $data): Invoice;
}
