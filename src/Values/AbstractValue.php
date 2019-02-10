<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

use Okaruto\Cryptonator\Exceptions\ValueInvalidException;

/**
 * Class AbstractValue
 *
 * @package Okaruto\Cryptonator\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
abstract class AbstractValue implements ValueInterface
{
    protected const ALLOWED_VALUES = [];

    /** @var string */
    protected $value;

    /** @var null|bool */
    protected $valid;

    /**
     * InvoiceStatus constructor.
     *
     * @param string $value Value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Return invoice status string
     *
     * @return string
     */
    public function value(): string
    {
        $this->valid(true);
        return $this->value;
    }

    /**
     * Return whether value is valid
     *
     * @param bool $throw Should exception be thrown?
     *
     * @return bool
     * @throws ValueInvalidException
     */
    public function valid(bool $throw = false): bool
    {
        if ($this->valid === null) {
            $this->valid = in_array($this->value, static::ALLOWED_VALUES);
        }

        if ($throw && !$this->valid) {
            throw new ValueInvalidException($this->value, self::ALLOWED_VALUES);
        }

        return $this->valid;
    }
}
