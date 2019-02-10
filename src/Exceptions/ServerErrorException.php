<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Exceptions;

/**
 * Class ServerErrorException
 *
 * @package Okaruto\Cryptonator\Exceptions
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class ServerErrorException extends \RuntimeException
{

    /**
     * ServerErrorException constructor.
     *
     * @param string $error      Error
     * @param int    $statusCode Error status code
     * @param string $body       Message body
     */
    public function __construct(string $error, int $statusCode, string $body)
    {
        parent::__construct(
            'Server error: ' . $error . ' Body: ' . $body,
            $statusCode
        );
    }
}
