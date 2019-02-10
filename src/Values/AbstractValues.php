<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

use Okaruto\Cryptonator\Exceptions\ValuesInvalidException;

/**
 * Class AbstractValues
 *
 * @package Okaruto\Cryptonator\Endpoint\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
abstract class AbstractValues implements ValuesInterface
{
    public const VALUE_MERCHANT_ID = 'merchant_id';
    public const VALUE_SECRET_HASH = 'secret_hash';
    public const VALUE_ORDER_ID = 'order_id';
    public const VALUE_ITEM_NAME = 'item_name';
    public const VALUE_ITEM_DESCRIPTION = 'item_description';
    public const VALUE_INVOICE_ID = 'invoice_id';
    public const VALUE_INVOICE_CURRENCY = 'invoice_currency';
    public const VALUE_INVOICE_AMOUNT = 'invoice_amount';
    public const VALUE_INVOICE_STATUS = 'invoice_status';
    public const VALUE_CHECKOUT_CURRENCY = 'checkout_currency';
    public const VALUE_SUCCESS_URL = 'success_url';
    public const VALUE_FAILED_URL = 'failed_url';
    public const VALUE_CONFIRMATION_POLICY = 'confirmation_policy';
    public const VALUE_LANGUAGE = 'language';

    protected const MANDATORY_KEYS = [];
    protected const EXPORT_KEYS = [];

    /** @var null|iterable */
    private $values;

    /** @var null|bool */
    private $valid;

    /**
     * AbstractValues constructor.
     *
     * @param null|iterable $values    Values
     */
    public function __construct(?iterable $values = [])
    {
        $this->values = $values;
    }

    /**
     * Return values as array
     *
     * @return array
     */
    public function array(): array
    {
        $this->valid(true);

        return array_reduce(
            static::EXPORT_KEYS,
            /**
             * Put values in keys
             *
             * @param array $values Values
             * @param mixed $key    Key
             *
             * @return array
             */
            function (array $values, $key): array {

                $values[$key] = $this->values[$key] ?? '';

                if ($values[$key] instanceof ValueInterface) {
                    $values[$key] = $values[$key]->value();
                }

                return $values;
            },
            []
        );
    }

    /**
     * Returns whether container contents are valid
     *
     * @param bool $throw Should exception be thrown?
     *
     * @return bool
     * @throws ValuesInvalidException
     */
    public function valid($throw = false): bool
    {
        if ($this->valid === null) {
            $this->valid =
                count(
                    array_diff(
                        static::MANDATORY_KEYS,
                        array_keys((array)$this->values)
                    )
                ) === 0
                && $this->validate();
        }

        if ($throw && !$this->valid) {
            throw new ValuesInvalidException();
        }

        return $this->valid;
    }

    /**
     * Return given value for key
     *
     * @param string     $key     Key
     * @param null|mixed $default Default value
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $this->values[$key] ?? $default;
    }

    /**
     * Validate values
     *
     * @return bool
     */
    abstract protected function validate(): bool;
}
