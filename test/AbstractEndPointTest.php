<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Okaruto\Cryptonator\Endpoint\AbstractEndpoint;
use Okaruto\Cryptonator\Endpoint\EndpointInterface;
use Okaruto\Cryptonator\Exceptions\JsonException;
use Okaruto\Cryptonator\Exceptions\ServerErrorException;
use Okaruto\Cryptonator\Values\AbstractValues;
use PHPUnit\Framework\TestCase;

class AbstractEndPointTest extends TestCase
{
    public function testQuerySend(): void
    {
        $container = [];
        $historyMiddleware = Middleware::history($container);
        $mockHandler = new MockHandler([new Response(200, [], '[]')]);

        $stack = HandlerStack::create($mockHandler);
        $stack->push($historyMiddleware);

        $client = new Client(['handler' => $stack]);

        $endpoint = $this->createQueryEndpoint($client, ['one' => 1, 'two' => '']);

        $endpoint->send();

        /** @var Request $request */
        $request = $container[0]['request'];

        $this->assertSame(
            [
                'scheme' => 'https',
                'host' => 'api.cryptonator.com',
                'path' => '/api/merchant/v1/test',
                'query' => 'merchant_id=merchantid&one=1&two=&secret_hash=f8da2d8c68000556e87d18714b86ba832556f73d',
            ],
            parse_url((string)$request->getUri())
        );
    }

    public function testPostSend(): void
    {
        $container = [];
        $historyMiddleware = Middleware::history($container);
        $mockHandler = new MockHandler([new Response(200, [], '[]')]);

        $stack = HandlerStack::create($mockHandler);
        $stack->push($historyMiddleware);

        $client = new Client(['handler' => $stack]);

        $endpoint = $this->createPostEndpoint($client, ['one' => 1, 'two' => '']);

        $endpoint->send();

        /** @var Request $request */
        $request = $container[0]['request'];

        $this->assertSame(
            [
                'scheme' => 'https',
                'host' => 'api.cryptonator.com',
                'path' => '/api/merchant/v1/test',
            ],
            parse_url((string)$request->getUri())
        );
    }

    public function testValidResponse(): void
    {
        $mockHandler = new MockHandler([new Response(200, [], '{"one": 1}')]);
        $client = new Client(['handler' => HandlerStack::create($mockHandler)]);

        $endpoint = $this->createQueryEndpoint($client, []);

        $this->assertSame(['one' => 1], $endpoint->send());
    }

    public function testMalformedJsonResponse(): void
    {
        $mockHandler = new MockHandler([new Response(200, [], 'invalid')]);
        $client = new Client(['handler' => HandlerStack::create($mockHandler)]);

        $endpoint = $this->createQueryEndpoint($client, []);

        $this->expectException(JsonException::class);
        $endpoint->send();
    }

    public function testServerError(): void
    {
        $mockHandler = new MockHandler([new Response(400)]);
        $client = new Client(['handler' => HandlerStack::create($mockHandler)]);

        $endpoint = $this->createQueryEndpoint($client, []);

        $this->expectException(ServerErrorException::class);
        $endpoint->send();
    }

    private function createQueryEndpoint(Client $client, array $values): EndpointInterface
    {
        $values = new class($values) extends AbstractValues
        {
            protected const EXPORT_KEYS = ['one', 'two'];
            protected function validate(): bool { return true; }
        };

        return new class(
            $client,
            'merchantid',
            'secret',
            $values
        ) extends AbstractEndpoint
        {
            protected const API_ENDPOINT = 'test';
            protected const API_TYPE = self::API_TYPE_QUERY;
        };
    }

    private function createPostEndpoint(Client $client, array $values): EndpointInterface
    {
        $values = new class($values) extends AbstractValues
        {
            protected const EXPORT_KEYS = ['one', 'two'];
            protected function validate(): bool { return true; }
        };

        return new class(
            $client,
            'merchantid',
            'secret',
            $values
        ) extends AbstractEndpoint
        {
            protected const API_ENDPOINT = 'test';
            protected const API_TYPE = self::API_TYPE_POST;
        };
    }
}
