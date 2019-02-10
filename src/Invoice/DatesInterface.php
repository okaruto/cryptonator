<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Invoice;

/**
 * Interface DatesInterface
 *
 * @package Okaruto\Cryptonator\Invoice
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
interface DatesInterface
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
     * Return invoice created data/time
     *
     * @return \DateTimeImmutable
     */
    public function created(): \DateTimeImmutable;

    /**
     * Return invoice expires date/time
     *
     * @return \DateTimeImmutable
     */
    public function expires(): \DateTimeImmutable;

    /**
     * Return invoice date/time
     *
     * @return \DateTimeImmutable
     */
    public function dateTime(): \DateTimeImmutable;
}
