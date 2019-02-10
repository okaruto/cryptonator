<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Invoice;

/**
 * Interface DetailsInterface
 *
 * @package Okaruto\Cryptonator\Invoice
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
interface DetailsInterface
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
     * Return invoice id
     *
     * @return string
     */
    public function identifier(): string;

    /**
     * Return invoice amount
     *
     * @return float
     */
    public function amount(): float;

    /**
     * Return invoice currency
     *
     * @return string
     */
    public function currency(): string;

    /**
     * Return invoice status
     *
     * @return string
     */
    public function status(): string;

    /**
     * Return invoice url
     *
     * @return string
     */
    public function url(): string;
}
