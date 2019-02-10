<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use GuzzleHttp\Client;
use Okaruto\Cryptonator\Exceptions\InvoiceCollectionInvalidException;
use Okaruto\Cryptonator\Invoice;
use Okaruto\Cryptonator\InvoiceCollection;
use Okaruto\Cryptonator\MerchantApi;
use PHPUnit\Framework\TestCase;

/**
 * Class InvoiceCollectionTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class InvoiceCollectionTest extends TestCase
{
    use PrepareClientTrait;

    const MERCHANT_ID = 'abcdef1234567890';
    const SECRET = '0987654321fedcba';

    public function testValidInvoiceCollection(): void
    {
        $validInvoiceList = [
            'invoice_count' => 5,
            'invoice_list' => [
                '54eca32985ca86f4a5ea60121ae19231',
                'db16fdccce788c4ea335acef06e29042',
                '730d1b3e512fe81e91f5c62af8e5ba76',
                '0146217e08b8aa4515086edaf72bc264',
                '94a45749b7cad8a004a6a52458e4c43a',
            ],
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            $validInvoiceList
        );

        $this->assertSame(true, $collection->valid());
    }

    public function testInvalidInvoice(): void
    {
        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            []
        );

        $this->assertSame(false, $collection->valid());
    }

    public function testInvalidInvoiceException(): void
    {
        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            []
        );

        $this->expectException(InvoiceCollectionInvalidException::class);
        $collection->list();
    }

    public function testInvalidInvoiceCount(): void
    {
        $validInvoiceList = [
            'invoice_count' => 'invalid',
            'invoice_list' => [
                '54eca32985ca86f4a5ea60121ae19231',
                'db16fdccce788c4ea335acef06e29042',
                '730d1b3e512fe81e91f5c62af8e5ba76',
                '0146217e08b8aa4515086edaf72bc264',
                '94a45749b7cad8a004a6a52458e4c43a',
            ],
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            $validInvoiceList
        );

        $this->assertSame(false, $collection->valid());
    }

    public function testInvalidInvoiceListObject(): void
    {
        $validInvoiceList = [
            'invoice_count' => 1,
            'invoice_list' => [
                new \stdClass(),
            ],
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            $validInvoiceList
        );

        $this->assertSame(false, $collection->valid());
    }

    public function testInvalidInvoiceListInteger(): void
    {
        $validInvoiceList = [
            'invoice_count' => 1,
            'invoice_list' => [
                12345,
            ],
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            $validInvoiceList
        );

        $this->assertSame(false, $collection->valid());
    }

    public function testInvalidInvoiceListFloat(): void
    {
        $validInvoiceList = [
            'invoice_count' => 1,
            'invoice_list' => [
                1.45,
            ],
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            $validInvoiceList
        );

        $this->assertSame(false, $collection->valid());
    }

    public function testInvalidInvoiceListArray(): void
    {
        $validInvoiceList = [
            'invoice_count' => 1,
            'invoice_list' => [
                ['some', 'stuff'],
            ],
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            $validInvoiceList
        );

        $this->assertSame(false, $collection->valid());
    }

    public function testInvalidInvoiceLisBoolean(): void
    {
        $validInvoiceList = [
            'invoice_count' => 1,
            'invoice_list' => [
                true,
            ],
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            $validInvoiceList
        );

        $this->assertSame(false, $collection->valid());
    }

    public function testInvoiceCollectionCount(): void
    {
        $validInvoiceList = [
            'invoice_count' => 5,
            'invoice_list' => [
                '54eca32985ca86f4a5ea60121ae19231',
                'db16fdccce788c4ea335acef06e29042',
                '730d1b3e512fe81e91f5c62af8e5ba76',
                '0146217e08b8aa4515086edaf72bc264',
                '94a45749b7cad8a004a6a52458e4c43a',
            ],
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            $validInvoiceList
        );

        $this->assertSame(5, $collection->count());
    }

    public function testInvoiceCollectionList(): void
    {
        $list = [
            '54eca32985ca86f4a5ea60121ae19231',
            'db16fdccce788c4ea335acef06e29042',
            '730d1b3e512fe81e91f5c62af8e5ba76',
            '0146217e08b8aa4515086edaf72bc264',
            '94a45749b7cad8a004a6a52458e4c43a',
        ];

        $validInvoiceList = [
            'invoice_count' => 5,
            'invoice_list' => $list,
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            $validInvoiceList
        );

        $this->assertSame($list, $collection->list());
    }

    public function testInvoiceCollectionHas(): void
    {

        $validInvoiceList = [
            'invoice_count' => 5,
            'invoice_list' => [
                '54eca32985ca86f4a5ea60121ae19231',
                'db16fdccce788c4ea335acef06e29042',
                '730d1b3e512fe81e91f5c62af8e5ba76',
                '0146217e08b8aa4515086edaf72bc264',
                '94a45749b7cad8a004a6a52458e4c43a',
            ],
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(new Client(), 'merchantid', 'secret'),
            $validInvoiceList
        );

        $this->assertSame(true, $collection->has('54eca32985ca86f4a5ea60121ae19231'));
        $this->assertSame(true, $collection->has('db16fdccce788c4ea335acef06e29042'));
        $this->assertSame(true, $collection->has('730d1b3e512fe81e91f5c62af8e5ba76'));
        $this->assertSame(true, $collection->has('0146217e08b8aa4515086edaf72bc264'));
        $this->assertSame(true, $collection->has('94a45749b7cad8a004a6a52458e4c43a'));

        $this->assertSame(false, $collection->has('abcdef1234567890abcdef012345678'));
    }

    public function testInvoiceCollectionInvoice(): void
    {
        $validInvoiceList = [
            'invoice_count' => 1,
            'invoice_list' => [
                '54eca32985ca86f4a5ea60121ae19231',
            ],
        ];

        $container = [];

        $getInvoiceResponse = [
            'order_id' => 'test-order-id',
            'amount' => '13.37000000',
            'currency' => 'usd',
            'status' => 'cancelled',
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(
                $this->client(json_encode($getInvoiceResponse), 200, $container),
                self::MERCHANT_ID,
                self::SECRET
            ),
            $validInvoiceList
        );

        $invoice = $collection->invoice('54eca32985ca86f4a5ea60121ae19231');

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertSame(true, $invoice->valid());
        $this->assertSame('test-order-id', $invoice->orderId());
    }

    public function testInvoiceCollectionInvoiceNotExisting(): void
    {
        $validInvoiceList = [
            'invoice_count' => 1,
            'invoice_list' => [
                '54eca32985ca86f4a5ea60121ae19231',
            ],
        ];

        $container = [];

        $getInvoiceResponse = [
            'order_id' => 'test-order-id',
            'amount' => '13.37000000',
            'currency' => 'usd',
            'status' => 'cancelled',
        ];

        $collection = new InvoiceCollection(
            new MerchantApi(
                $this->client(json_encode($getInvoiceResponse), 200, $container),
                self::MERCHANT_ID,
                self::SECRET
            ),
            $validInvoiceList
        );

        $this->expectException(\LogicException::class);
        $collection->invoice('abcdef1234567890abcdef012345678');
    }
}
