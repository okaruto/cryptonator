<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator;

use Okaruto\Cryptonator\Exceptions\InvoiceInvalidException;
use Okaruto\Cryptonator\Invoice\CheckoutInterface;
use Okaruto\Cryptonator\Invoice\DatesInterface;
use Okaruto\Cryptonator\Invoice\DetailsInterface;

/**
 * Interface InvoiceInterface
 *
 * @package Okaruto\Cryptonator
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
interface InvoiceInterface
{
    /**
     * Returns whether invoice is valid
     *
     * @param bool $throw Should method throw exception?
     *
     * @return bool
     * @throws InvoiceInvalidException
     */
    public function valid($throw = false): bool;

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
    public function full($throw = false): bool;

    /**
     * Returns whether invoie only a partial invoice
     *
     * This means only basic details
     *
     * @return bool
     */
    public function partial(): bool;

    /**
     * Returns order id
     *
     * @return string
     */
    public function orderId(): string;

    /**
     * Return invoice details
     *
     * @return DetailsInterface
     */
    public function details(): DetailsInterface;

    /**
     * Return checkout details
     *
     * @return CheckoutInterface
     */
    public function checkout(): CheckoutInterface;

    /**
     * Return invoice dates
     *
     * @return DatesInterface
     */
    public function dates(): DatesInterface;
}
