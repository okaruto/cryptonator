<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Exceptions;

/**
 * Class InsufficientValuesException
 *
 * @package Okaruto\Cryptonator\Exceptions
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class InsufficientValuesException extends \LogicException
{
    /**
     * InsufficientValuesException constructor.
     */
    public function __construct()
    {
        parent::__construct('Insufficient values for hash generation');
    }
}
