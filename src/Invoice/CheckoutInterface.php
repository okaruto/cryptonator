<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Invoice;

/**
 * Interface CheckoutInterface
 *
 * @package Okaruto\Cryptonator\Invoice
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
interface CheckoutInterface
{
    /**
     * Return whether details are valid
     *
     * @param bool $throw   Should exception be thrown?
     *
     * @return bool
     * @throws \LogicException
     */
    public function valid(bool $throw = false): bool;

    /**
     * Return cryptocurrency address
     *
     * @return string
     */
    public function address(): string;

    /**
     * Return cryptocurrency amount
     *
     * @return float
     */
    public function amount(): float;

    /**
     * Return cryptocurrency type
     *
     * @return string
     */
    public function currency(): string;
}
