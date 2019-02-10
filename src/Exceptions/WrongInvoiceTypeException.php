<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Exceptions;

/**
 * Class WrongInvoiceTypeException
 *
 * @package Okaruto\Cryptonator\Exceptions
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class WrongInvoiceTypeException extends \RuntimeException
{
    /**
     * WrongInvoiceTypeException constructor.
     *
     * @param array $details
     */
    public function __construct(array $details)
    {
        parent::__construct('Invoice type could not be determined from details: ' . json_encode($details));
    }
}
