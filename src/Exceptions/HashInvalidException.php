<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Exceptions;

/**
 * Class HashInvalidException
 *
 * @package Okaruto\Cryptonator\Exceptions
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class HashInvalidException extends \LogicException
{
    /**
     * HashInvalidException constructor.
     */
    public function __construct()
    {
        parent::__construct('Secret hash invalid');
    }
}
