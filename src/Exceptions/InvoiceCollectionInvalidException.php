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
final class InvoiceCollectionInvalidException extends \LogicException
{
    public function __construct(array $data)
    {
        parent::__construct('InvoiceCollection is invalid: ' . json_encode($data));
    }
}
