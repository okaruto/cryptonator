<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

use Okaruto\Cryptonator\Exceptions\ValueInvalidException;

/**
 * Interface ValueInterface
 *
 * @package Okaruto\Cryptonator\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
interface ValueInterface
{
    /**
     * Return invoice status string
     *
     * @return string
     */
    public function value(): string;

    /**
     * Return whether value is valid
     *
     * @param bool $throw Should exception be thrown?
     *
     * @return bool
     * @throws ValueInvalidException
     */
    public function valid(bool $throw = false): bool;
}
