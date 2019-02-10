<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Exceptions;

/**
 * Class JsonException
 *
 * @package Okaruto\Cryptonator\Exceptions
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class JsonException extends \RuntimeException
{
    public function __construct(string $content, int $errorCode)
    {
        parent::__construct('Could not decode JSON: ' . $content, $errorCode);
    }
}
