<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Invoice;

use Okaruto\Cryptonator\Values\InvoiceCurrencyValue;
use Okaruto\Cryptonator\Values\InvoiceStatusValue;

/**
 * Class Details
 *
 * @package Okaruto\Cryptonator\Invoice
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class Details extends AbstractInvoiceData implements DetailsInterface
{
    /** @var string */
    private $identifier;

    /** @var float */
    private $amount;

    /** @var InvoiceCurrencyValue */
    private $currency;

    /** @var InvoiceStatusValue */
    private $status;

    /** @var string */
    private $url;

    /**
     * Details constructor.
     *
     * @param string               $identifier Invoice id
     * @param float                $amount     Invoice amount
     * @param InvoiceCurrencyValue $currency   Invoice currency
     * @param InvoiceStatusValue   $status     Invoice status
     * @param string               $url        Invoice url
     */
    public function __construct(
        string $identifier,
        float $amount,
        InvoiceCurrencyValue $currency,
        InvoiceStatusValue $status,
        string $url
    ) {
        $this->identifier = $identifier;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->status = $status;
        $this->url = $url;
    }

    /**
     * Return invoice id
     *
     * @return string
     */
    public function identifier(): string
    {
        $this->valid(true);
        return $this->identifier;
    }

    /**
     * Return invoice amount
     *
     * @return float
     */
    public function amount(): float
    {
        $this->valid(true);
        return $this->amount;
    }

    /**
     * Return invoice currency
     *
     * @return string
     */
    public function currency(): string
    {
        $this->valid(true);
        return $this->currency->value();
    }

    /**
     * Return invoice status
     *
     * @return string
     */
    public function status(): string
    {
        $this->valid(true);
        return $this->status->value();
    }

    /**
     * Return invoice url
     *
     * @return string
     */
    public function url(): string
    {
        $this->valid(true);
        return $this->url;
    }

    /**
     * Return collection of fields as boolean array
     *
     * @return array
     */
    protected function fields(): array
    {
        return [
            $this->amount > 0,
            $this->currency->valid(),
            $this->status->valid(),
        ];
    }
}
