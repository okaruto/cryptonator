<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Invoice;

use Okaruto\Cryptonator\Values\CheckoutCurrencyValue;

/**
 * Class Checkout
 *
 * @package Okaruto\Cryptonator\Invoice
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class Checkout extends AbstractInvoiceData implements CheckoutInterface
{
    /** @var string */
    private $address;

    /** @var float */
    private $amount;

    /** @var CheckoutCurrencyValue */
    private $currency;

    /**
     * Checkout constructor.
     *
     * @param string                $address  Cryptocurrency address
     * @param float                 $amount   Cryptocurrency amount
     * @param CheckoutCurrencyValue $currency Cryptocurrency
     */
    public function __construct(string $address, float $amount, CheckoutCurrencyValue $currency)
    {
        $this->address = $address;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * Return cryptocurrency address
     *
     * @return string
     */
    public function address(): string
    {
        $this->valid(true);
        return $this->address;
    }

    /**
     * Return cryptocurrency amount
     *
     * @return float
     */
    public function amount(): float
    {
        $this->valid(true);
        return $this->amount;
    }

    /**
     * Return cryptocurrency type
     *
     * @return string
     */
    public function currency(): string
    {
        $this->valid(true);
        return $this->currency->value();
    }

    /**
     * Return collection of fields as boolean array
     *
     * @return array
     */
    protected function fields(): array
    {
        return [
            !empty($this->address),
            $this->amount > 0,
            $this->currency->valid()
        ];
    }
}
