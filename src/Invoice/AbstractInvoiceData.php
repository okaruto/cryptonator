<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Invoice;

use Okaruto\Cryptonator\Values\ReducedValues;

/**
 * Class AbstractInvoiceData
 *
 * @package Okaruto\Cryptonator\Invoice
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
abstract class AbstractInvoiceData
{
    /** @var null|bool */
    private $valid;

    /**
     * Return whether details are valid
     *
     * @param bool $throw   Should exception be thrown?
     *
     * @return bool
     * @throws \LogicException
     */
    public function valid(bool $throw = false): bool
    {
        if ($this->valid === null) {
            $this->valid = (new ReducedValues($this->fields()))->valid();
        }

        if ($throw && !$this->valid) {
            throw new \LogicException('Some of the details values are invalid');
        }

        return $this->valid;
    }

    /**
     * Return collection of fields as boolean array
     *
     * @return array
     */
    abstract protected function fields(): array;
}
