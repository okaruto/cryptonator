<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use GuzzleHttp\Psr7\Request;
use Okaruto\Cryptonator\Endpoint\ListInvoices;
use Okaruto\Cryptonator\Exceptions\JsonException;
use Okaruto\Cryptonator\Exceptions\ServerErrorException;
use Okaruto\Cryptonator\Values\ListInvoicesValues;
use PHPUnit\Framework\TestCase;

class EndpointListInvoicesTest extends TestCase
{
    use PrepareClientTrait;

    const MERCHANT_ID = 'abcdef1234567890';
    const SECRET = '0987654321fedcba';

    public function testListInvoices(): void
    {
        $container = [];

        $invoiceListResponse = [
            'invoice_count' => 5,
            'invoice_list' => [
                '54eca32985ca86f4a5ea60121ae19231',
                'db16fdccce788c4ea335acef06e29042',
                '730d1b3e512fe81e91f5c62af8e5ba76',
                '0146217e08b8aa4515086edaf72bc264',
                '94a45749b7cad8a004a6a52458e4c43a',
            ],
        ];

        $endpoint = new ListInvoices(
            $this->client(json_encode($invoiceListResponse), 200, $container),
            self::MERCHANT_ID,
            self::SECRET,
            new ListInvoicesValues()
        );

        $result = $endpoint->send();

        /** @var Request $request */
        $request = $container[0]['request'];

        $this->assertSame(
            [
                'scheme' => 'https',
                'host' => 'api.cryptonator.com',
                'path' => '/api/merchant/v1/listinvoices',
                'query' => 'merchant_id=abcdef1234567890&invoice_status=&invoice_currency=&checkout_currency=&secret_hash=75324e23f01d78787d4c1d7eeaa555edf15d53ae',
            ],
            parse_url((string)$request->getUri())
        );

        $this->assertSame($invoiceListResponse, $result);
    }

    public function testListInvoicesServerErrorException(): void
    {
        $container = [];

        $endpoint = new ListInvoices(
            $this->client(json_encode(['error' => 'Bad Request']), 400, $container),
            self::MERCHANT_ID,
            self::SECRET,
            new ListInvoicesValues()
        );

        $this->expectException(ServerErrorException::class);
        $endpoint->send();
    }

    public function testListInvoicesJsonException(): void
    {
        $container = [];

        $endpoint = new ListInvoices(
            $this->client('invalid', 200, $container),
            self::MERCHANT_ID,
            self::SECRET,
            new ListInvoicesValues()
        );

        $this->expectException(JsonException::class);
        $endpoint->send();
    }
}
