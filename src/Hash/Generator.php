<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Hash;

use Okaruto\Cryptonator\Exceptions\InsufficientValuesException;
use Okaruto\Cryptonator\Exceptions\SecretHashIncludedException;
use Okaruto\Cryptonator\Values\AbstractValues;

/**
 * Class Generator
 *
 * @package Okaruto\Cryptonator\Hash
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class Generator
{
    /** @var string */
    private $secret;

    /** @var array */
    private $values;

    /**
     * Generator constructor.
     *
     * @param string $secret Secret
     * @param array  $values Values
     */
    public function __construct(string $secret, array $values)
    {
        $this->secret = $secret;
        $this->values = $values;
    }

    /**
     * Generate hash given values
     *
     * @see https://cryptonator.zendesk.com/hc/en-us/categories/200829259
     *      Validate HTTP-notifications
     *
     * @return string
     * @throws InsufficientValuesException
     * @throws SecretHashIncludedException
     */
    public function hash(): string
    {
        if (empty($this->values)) {
            throw new InsufficientValuesException();
        } elseif (isset($this->values[AbstractValues::VALUE_SECRET_HASH])) {
            throw new SecretHashIncludedException();
        }

        $values = join('&', array_merge($this->values, [$this->secret]));

        return sha1($values);
    }
}
