<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

use Okaruto\Cryptonator\Exceptions\NoExportKeysDefinedException;

/**
 * Interface ValuesInterface
 *
 * @package Okaruto\Cryptonator\Endpoint\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
interface ValuesInterface
{
    /**
     * Return values as array
     *
     * @return array
     */
    public function array(): array;

    /**
     * Return given value for key
     *
     * @param string     $key     Key
     * @param null|mixed $default Default value
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null);
}
