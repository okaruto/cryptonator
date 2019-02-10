<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Exceptions;

/**
 * Class InvoiceInvalidException
 *
 * @package Okaruto\Cryptonator\Exceptions
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class InvoiceInvalidException extends \LogicException
{
    public function __construct(array $details)
    {
        parent::__construct('Invoice is invalid: ' . json_encode($details));
    }
}
