<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator;

use GuzzleHttp\ClientInterface;
use Okaruto\Cryptonator\Endpoint\AbstractEndpoint;
use Okaruto\Cryptonator\Endpoint\CreateInvoice;
use Okaruto\Cryptonator\Endpoint\GetInvoice;
use Okaruto\Cryptonator\Endpoint\ListInvoices;
use Okaruto\Cryptonator\Hash\Generator;
use Okaruto\Cryptonator\Hash\Validator;
use Okaruto\Cryptonator\Values\CheckoutCurrencyValue;
use Okaruto\Cryptonator\Values\ConfirmationPolicyValue;
use Okaruto\Cryptonator\Values\CreateInvoiceValues;
use Okaruto\Cryptonator\Values\GetInvoiceValues;
use Okaruto\Cryptonator\Values\InvoiceCurrencyValue;
use Okaruto\Cryptonator\Values\InvoiceStatusValue;
use Okaruto\Cryptonator\Values\LanguageValue;
use Okaruto\Cryptonator\Values\ListInvoicesValues;
use Okaruto\Cryptonator\Values\StartPaymentValues;

/**
 * Class MerchantApi
 *
 * @package Okaruto\Cryptonator
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class MerchantApi implements MerchantApiInterface
{
    public const INVOICE_STATUS_UNPAID = InvoiceStatusValue::INVOICE_STATUS_UNPAID;
    public const INVOICE_STATUS_PAID = InvoiceStatusValue::INVOICE_STATUS_PAID;
    public const INVOICE_STATUS_CANCELLED = InvoiceStatusValue::INVOICE_STATUS_CANCELLED;
    public const INVOICE_STATUS_MISPAID = InvoiceStatusValue::INVOICE_STATUS_MISPAID;
    public const INVOICE_STATUS_CONFIRMING = InvoiceStatusValue::INVOICE_STATUS_CONFIRMING;

    public const INVOICE_CURRENCY_USD = InvoiceCurrencyValue::INVOICE_CURRENCY_USD;
    public const INVOICE_CURRENCY_EUR = InvoiceCurrencyValue::INVOICE_CURRENCY_EUR;
    public const INVOICE_CURRENCY_RUR = InvoiceCurrencyValue::INVOICE_CURRENCY_RUR;

    public const CHECKOUT_CURRENCY_BITCOIN = CheckoutCurrencyValue::CHECKOUT_CURRENCY_BITCOIN;
    public const CHECKOUT_CURRENCY_BITCOINCASH = CheckoutCurrencyValue::CHECKOUT_CURRENCY_BITCOINCASH;
    public const CHECKOUT_CURRENCY_ETHEREUM = CheckoutCurrencyValue::CHECKOUT_CURRENCY_ETHEREUM;
    public const CHECKOUT_CURRENCY_ETHEREUMCLASSIC = CheckoutCurrencyValue::CHECKOUT_CURRENCY_ETHEREUMCLASSIC;
    public const CHECKOUT_CURRENCY_LITECOIN = CheckoutCurrencyValue::CHECKOUT_CURRENCY_LITECOIN;
    public const CHECKOUT_CURRENCY_DASH = CheckoutCurrencyValue::CHECKOUT_CURRENCY_DASH;
    public const CHECKOUT_CURRENCY_ZCASH = CheckoutCurrencyValue::CHECKOUT_CURRENCY_ZCASH;
    public const CHECKOUT_CURRENCY_DOGECOIN = CheckoutCurrencyValue::CHECKOUT_CURRENCY_DOGECOIN;
    public const CHECKOUT_CURRENCY_PEERCOIN = CheckoutCurrencyValue::CHECKOUT_CURRENCY_PEERCOIN;

    public const CONFIRMATION_POLICY_FAST = ConfirmationPolicyValue::CONFIRMATION_POLICY_FAST;
    public const CONFIRMATION_POLICY_NORMAL = ConfirmationPolicyValue::CONFIRMATION_POLICY_NORMAL;
    public const CONFIRMATION_POLICY_SLOW = ConfirmationPolicyValue::CONFIRMATION_POLICY_SLOW;

    public const LANGUAGE_EN = LanguageValue::LANGUAGE_EN;
    public const LANGUAGE_DE = LanguageValue::LANGUAGE_DE;
    public const LANGUAGE_ES = LanguageValue::LANGUAGE_EN;
    public const LANGUAGE_FR = LanguageValue::LANGUAGE_FR;
    public const LANGUAGE_RU = LanguageValue::LANGUAGE_RU;
    public const LANGUAGE_CN = LanguageValue::LANGUAGE_CN;

    /** @var ClientInterface */
    private $client;

    /** @var string */
    private $merchantId;

    /** @var string */
    private $secret;

    /**
     * MerchantApi constructor.
     *
     * @param ClientInterface $client     HTTP client
     * @param string          $merchantId Merchant id
     * @param string          $secret     Merchant secret
     */
    public function __construct(ClientInterface $client, string $merchantId, string $secret)
    {
        $this->client = $client;
        $this->merchantId = $merchantId;
        $this->secret = $secret;
    }

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
    ): InvoiceCollection {

        $endpoint = new ListInvoices(
            $this->client,
            $this->merchantId,
            $this->secret,
            new ListInvoicesValues(
                array_filter(
                    [
                        StartPaymentValues::VALUE_INVOICE_STATUS => $invoiceStatus,
                        StartPaymentValues::VALUE_INVOICE_CURRENCY => $invoiceCurrency,
                        StartPaymentValues::VALUE_CHECKOUT_CURRENCY => $checkoutCurrency,
                    ]
                )
            )
        );

        return new InvoiceCollection($this, $endpoint->send());
    }

    /**
     * Return a specific invoice
     *
     * @param string $invoiceId
     *
     * @return Invoice
     */
    public function getInvoice(string $invoiceId): Invoice
    {
        $endpoint = new GetInvoice(
            $this->client,
            $this->merchantId,
            $this->secret,
            new GetInvoiceValues([StartPaymentValues::VALUE_INVOICE_ID => $invoiceId])
        );

        return new Invoice($endpoint->send());
    }

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
    ): Invoice {

        $values = new CreateInvoiceValues(
            array_filter(
                [
                    StartPaymentValues::VALUE_ITEM_NAME => $itemName,
                    StartPaymentValues::VALUE_CHECKOUT_CURRENCY => new CheckoutCurrencyValue($checkoutCurrency),
                    StartPaymentValues::VALUE_INVOICE_AMOUNT => $invoiceAmount,
                    StartPaymentValues::VALUE_INVOICE_CURRENCY => new InvoiceCurrencyValue($invoiceCurrency),
                    StartPaymentValues::VALUE_ORDER_ID => $orderId,
                    StartPaymentValues::VALUE_ITEM_DESCRIPTION => $itemDescription,
                    StartPaymentValues::VALUE_SUCCESS_URL => $successUrl,
                    StartPaymentValues::VALUE_FAILED_URL => $failedUrl,
                    StartPaymentValues::VALUE_CONFIRMATION_POLICY => $confirmationPolicy === null
                        ? false
                        : new ConfirmationPolicyValue($confirmationPolicy),
                    StartPaymentValues::VALUE_LANGUAGE => $language === null
                        ? false
                        : new LanguageValue($language),
                ]
            )
        );

        $result = (new CreateInvoice(
            $this->client,
            $this->merchantId,
            $this->secret,
            $values
        ))->send();

        return new Invoice($result);
    }

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
    ): string {

        $values = new StartPaymentValues(
            array_filter(
                [
                    StartPaymentValues::VALUE_ITEM_NAME => $itemName,
                    StartPaymentValues::VALUE_INVOICE_AMOUNT => $invoiceAmount,
                    StartPaymentValues::VALUE_INVOICE_CURRENCY => new InvoiceCurrencyValue($invoiceCurrency),
                    StartPaymentValues::VALUE_ORDER_ID => $orderId,
                    StartPaymentValues::VALUE_ITEM_DESCRIPTION => $itemDescription,
                    StartPaymentValues::VALUE_SUCCESS_URL => $successUrl,
                    StartPaymentValues::VALUE_FAILED_URL => $failedUrl,
                    StartPaymentValues::VALUE_LANGUAGE => $language,
                ]
            )
        );

        return join(
            '',
            [
                AbstractEndpoint::API_URL . 'startpayment',
                '?',
                http_Build_query(
                    array_merge(
                        [StartPaymentValues::VALUE_MERCHANT_ID => $this->merchantId],
                        array_filter($values->array())
                    )
                ),
            ]
        );
    }

    /**
     * Create an invoice from HTTP notification
     *
     * @param array $data Data from HTTP notification
     *
     * @return Invoice
     */
    public function httpNotificationInvoice(array $data): Invoice
    {
        if (!isset($data['secret_hash'])) {
            throw new \RuntimeException(
                'HTTP notification data does not contain secret_hash key'
            );
        }

        if (($data['merchant_id'] ?? '') !== $this->merchantId) {
            throw new \RuntimeException(
                sprintf(
                    'Merchant id does not match own (%s) vs (%s)',
                    $this->merchantId,
                    ($data['merchant_id'] ?? '')
                )
            );
        }

        $hash = $data['secret_hash'];
        unset($data['secret_hash']);

        $validator = new Validator(new Generator($this->secret, $data), $hash);
        $validator->valid(true);

        return new Invoice($data);
    }
}
