<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Exceptions;

/**
 * Class ValueInvalidException
 *
 * @package Okaruto\Cryptonator\Exceptions
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class ValueInvalidException extends \RuntimeException
{
    public function __construct(string $value, array $allowed)
    {
        parent::__construct(
            sprintf(
                'Value invalid, given: (%s), allowed are: (%s)',
                $value,
                join(',', $allowed)
            )
        );
    }
}
