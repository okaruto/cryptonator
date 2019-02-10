<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Exceptions;

/**
 * Class ValuesInvalidException
 *
 * @package Okaruto\Cryptonator\Exceptions
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class ValuesInvalidException extends \LogicException
{
    public function __construct()
    {
        parent::__construct('At least one container value is invalid');
    }
}
