<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator;

use Okaruto\Cryptonator\Exceptions\InvoiceInvalidException;
use Okaruto\Cryptonator\Exceptions\WrongInvoiceTypeException;
use Okaruto\Cryptonator\Invoice\Checkout;
use Okaruto\Cryptonator\Invoice\CheckoutInterface;
use Okaruto\Cryptonator\Invoice\Dates;
use Okaruto\Cryptonator\Invoice\DatesInterface;
use Okaruto\Cryptonator\Invoice\Details;
use Okaruto\Cryptonator\Invoice\DetailsInterface;
use Okaruto\Cryptonator\Values\CheckoutCurrencyValue;
use Okaruto\Cryptonator\Values\InvoiceCurrencyValue;
use Okaruto\Cryptonator\Values\InvoiceStatusValue;

/**
 * Class Invoice
 *
 * @package Okaruto\Cryptonator
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class Invoice implements InvoiceInterface
{
    private const TYPE_FULL = 'full';
    private const TYPE_PARTIAL = 'partial';

    private const SHARED_FIELD_ORDER_ID = 'order_id';

    private const PARTIAL_FIELD_AMOUNT = 'amount';
    private const PARTIAL_FIELD_CURRENCY = 'currency';
    private const PARTIAL_FIELD_STATUS = 'status';

    private const FULL_FIELD_INVOICE_ID = 'invoice_id';
    private const FULL_FIELD_INVOICE_CREATED = 'invoice_created';
    private const FULL_FIELD_INVOICE_EXPIRES = 'invoice_expires';
    private const FULL_FIELD_INVOICE_AMOUNT = 'invoice_amount';
    private const FULL_FIELD_INVOICE_CURRENCY = 'invoice_currency';
    private const FULL_FIELD_INVOICE_STATUS = 'invoice_status';
    private const FULL_FIELD_INVOICE_URL = 'invoice_url';
    private const FULL_FIELD_CHECKOUT_ADDRESS = 'checkout_address';
    private const FULL_FIELD_CHECKOUT_AMOUNT = 'checkout_amount';
    private const FULL_FIELD_CHECKOUT_CURRENCY = 'checkout_currency';
    private const FULL_FIELD_DATE_TIME = 'date_time';

    /** @var array */
    private $values;

    /** @var null|string */
    private $type;

    /** @var null|bool */
    private $valid;

    /** @var null|Details */
    private $details;

    /** @var null|Dates */
    private $dates;

    /** @var null|Checkout */
    private $checkout;

    /**
     * Invoice constructor.
     *
     * @param array $values Invoice values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * Returns whether invoice is a full invoice
     *
     * This means including cryptocurrency payment details
     *
     * @param bool $throw Should method throw exception?
     *
     * @return bool
     * @throws \LogicException
     */
    public function full($throw = false): bool
    {
        $correctType = $this->type() === self::TYPE_FULL;

        if ($throw && !$correctType) {
            throw new \LogicException('Trying access wrong invoice type: partial');
        }

        return $correctType;
    }

    /**
     * Returns whether invoie only a partial invoice
     *
     * This means only basic details
     *
     * @return bool
     */
    public function partial(): bool
    {
        return $this->type() === self::TYPE_PARTIAL;
    }

    /**
     * Returns type of invoice
     *
     * @return string
     * @throws WrongInvoiceTypeException
     */
    private function type(): string
    {
        if ($this->type === null) {
            if (isset($this->values[self::FULL_FIELD_INVOICE_STATUS])) {
                $this->type = self::TYPE_FULL;
            } elseif (isset($this->values[self::PARTIAL_FIELD_STATUS])) {
                $this->type = self::TYPE_PARTIAL;
            } else {
                throw new WrongInvoiceTypeException($this->values);
            }
        }

        return $this->type;
    }

    /**
     * Returns order id
     *
     * @return string
     */
    public function orderId(): string
    {
        $this->valid(true);
        return $this->values[self::SHARED_FIELD_ORDER_ID];
    }

    /**
     * Return invoice details
     *
     * @return DetailsInterface
     */
    public function details(): DetailsInterface
    {
        $this->valid(true);

        if ($this->details === null) {
            if ($this->full()) {
                $this->details = new Details(
                    $this->values[self::FULL_FIELD_INVOICE_ID],
                    (float)$this->values[self::FULL_FIELD_INVOICE_AMOUNT],
                    new InvoiceCurrencyValue($this->values[self::FULL_FIELD_INVOICE_CURRENCY]),
                    new InvoiceStatusValue($this->values[self::FULL_FIELD_INVOICE_STATUS]),
                    $this->values[self::FULL_FIELD_INVOICE_URL]
                );
            } else {
                $this->details = new Details(
                    '',
                    (float)$this->values[self::PARTIAL_FIELD_AMOUNT],
                    new InvoiceCurrencyValue($this->values[self::PARTIAL_FIELD_CURRENCY]),
                    new InvoiceStatusValue($this->values[self::PARTIAL_FIELD_STATUS]),
                    ''
                );
            }
        }

        return $this->details;
    }

    /**
     * Return checkout details
     *
     * @return CheckoutInterface
     */
    public function checkout(): CheckoutInterface
    {
        $this->valid(true);
        $this->full(true);

        if ($this->checkout === null) {
            $this->checkout = new Checkout(
                $this->values[self::FULL_FIELD_CHECKOUT_ADDRESS],
                (float) $this->values[self::FULL_FIELD_CHECKOUT_AMOUNT],
                new CheckoutCurrencyValue($this->values[self::FULL_FIELD_CHECKOUT_CURRENCY])
            );
        }

        return $this->checkout;
    }

    /**
     * Return invoice dates
     *
     * @return DatesInterface
     */
    public function dates(): DatesInterface
    {
        $this->valid();
        $this->full(true);

        if ($this->dates === null) {
            $this->dates = new Dates(
                (int)$this->values[self::FULL_FIELD_INVOICE_CREATED],
                (int)$this->values[self::FULL_FIELD_INVOICE_EXPIRES],
                (int)$this->values[self::FULL_FIELD_DATE_TIME]
            );
        }

        return $this->dates;
    }

    /**
     * Returns whether invoice is valid
     *
     * @param bool $throw Should method throw exception?
     *
     * @return bool
     * @throws InvoiceInvalidException
     */
    public function valid($throw = false): bool
    {
        if ($this->valid === null) {
            $this->valid = $this->type() === self::TYPE_FULL
                ? $this->validFullInvoice()
                : $this->validPartialInvoice();
        }

        if (!$this->valid && $throw) {
            throw new InvoiceInvalidException($this->values);
        }

        return $this->valid;
    }

    /**
     * Determines whether full invoice is a valid
     *
     * @return bool
     */
    private function validFullInvoice(): bool
    {
        return isset(
            $this->values[self::SHARED_FIELD_ORDER_ID],
            $this->values[self::FULL_FIELD_INVOICE_AMOUNT],
            $this->values[self::FULL_FIELD_INVOICE_CURRENCY],
            $this->values[self::FULL_FIELD_INVOICE_STATUS],
            $this->values[self::FULL_FIELD_INVOICE_ID],
            $this->values[self::FULL_FIELD_INVOICE_CREATED],
            $this->values[self::FULL_FIELD_INVOICE_EXPIRES],
            $this->values[self::FULL_FIELD_INVOICE_URL],
            $this->values[self::FULL_FIELD_CHECKOUT_ADDRESS],
            $this->values[self::FULL_FIELD_CHECKOUT_AMOUNT],
            $this->values[self::FULL_FIELD_CHECKOUT_CURRENCY],
            $this->values[self::FULL_FIELD_DATE_TIME]
        );
    }

    /**
     * Determines whether partial invoice is a valid
     *
     * @return bool
     */
    private function validPartialInvoice(): bool
    {
        return isset(
            $this->values[self::SHARED_FIELD_ORDER_ID],
            $this->values[self::PARTIAL_FIELD_AMOUNT],
            $this->values[self::PARTIAL_FIELD_CURRENCY],
            $this->values[self::PARTIAL_FIELD_STATUS]
        );
    }
}
