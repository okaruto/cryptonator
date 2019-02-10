<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use GuzzleHttp\Psr7\Request;
use Okaruto\Cryptonator\Endpoint\GetInvoice;
use Okaruto\Cryptonator\Values\AbstractValues;
use Okaruto\Cryptonator\Values\GetInvoiceValues;
use PHPUnit\Framework\TestCase;

class EndpointGetInvoiceTest extends TestCase
{
    use PrepareClientTrait;

    const MERCHANT_ID = 'abcdef1234567890';
    const SECRET = '0987654321fedcba';

    public function testGetInvoice(): void
    {
        $container = [];

        $getInvoiceResponse = [
            'order_id' => 'test-order-id',
            'amount' => '13.37000000',
            'currency' => 'usd',
            'status' => 'cancelled',
        ];

        $endpoint = new GetInvoice(
            $this->client(json_encode($getInvoiceResponse), 200, $container),
            self::MERCHANT_ID,
            self::SECRET,
            new GetInvoiceValues([AbstractValues::VALUE_INVOICE_ID => ''])
        );

        $result = $endpoint->send();

        /** @var Request $request */
        $request = $container[0]['request'];

        $this->assertSame(
            [
                'scheme' => 'https',
                'host' => 'api.cryptonator.com',
                'path' => '/api/merchant/v1/getinvoice',
                'query' => 'merchant_id=abcdef1234567890&invoice_id=&secret_hash=075e5e3c10ab3c9520d086d508443f964ea8dbc9',
            ],
            parse_url((string)$request->getUri())
        );

        $this->assertSame($getInvoiceResponse, $result);
    }
}
