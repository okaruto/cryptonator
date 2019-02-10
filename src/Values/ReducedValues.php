<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

/**
 * Class ReducedValues
 *
 * @package Okaruto\Cryptonator\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class ReducedValues
{
    /** @var array */
    private $values;

    /** @var null|bool */
    private $valid;

    /**
     * ReducedValues constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * Return whether all values are true
     *
     * @return bool
     */
    public function valid(): bool
    {
        if ($this->valid === null) {
            $this->valid = array_reduce(
                $this->values,
                function (bool $carry, bool $value): bool {
                    return $carry && $value;
                },
                true
            );
        }

        return $this->valid;
    }
}
