<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Exceptions;

/**
 * Class SecretHashIncludedException
 *
 * @package Okaruto\Cryptonator\Exceptions
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class SecretHashIncludedException extends \LogicException
{
    /**
     * SecretHashIncludedException constructor.
     */
    public function __construct()
    {
        parent::__construct('Given values include secret_hash key');
    }
}
