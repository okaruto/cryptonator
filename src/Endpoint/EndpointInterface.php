<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Endpoint;

use Okaruto\Cryptonator\Exceptions\JsonException;
use Okaruto\Cryptonator\Exceptions\ServerErrorException;

/**
 * Interface EndpointInterface
 *
 * @package Okaruto\Cryptonator\Endpoint
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
interface EndpointInterface
{
    /**
     * Send request to api endpoint
     *
     * @return array
     * @throws ServerErrorException
     * @throws JsonException
     */
    public function send(): array;
}
