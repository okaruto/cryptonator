<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

/**
 * Class PrepareClientTrait
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
trait PrepareClientTrait
{
    protected function client(string $content, int $code, array &$container): Client
    {
        $historyMiddleware = Middleware::history($container);

        $response = new Response(
            $code,
            [],
            $content
        );

        $mockHandler = new MockHandler([$response]);
        $stack = HandlerStack::create($mockHandler);
        $stack->push($historyMiddleware);

        return new Client(['handler' => $stack]);
    }
}
