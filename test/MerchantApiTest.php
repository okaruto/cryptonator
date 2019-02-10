<?php

declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use GuzzleHttp\Client;
use Okaruto\Cryptonator\Invoice;
use Okaruto\Cryptonator\InvoiceCollection;
use Okaruto\Cryptonator\MerchantApi;
use PHPUnit\Framework\TestCase;

/**
 * Class MerchantApiTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class MerchantApiTest extends TestCase
{

    use PrepareClientTrait;

    const MERCHANT_ID = 'b60d121b438a380c343d5ec3c2037564';
    const SECRET = '0987654321fedcba';

    public function testListInvoices(): void
    {
        $listResponse = [
            'invoice_count' => 5,
            'invoice_list' => [
                '54eca32985ca86f4a5ea60121ae19231',
                'db16fdccce788c4ea335acef06e29042',
                '730d1b3e512fe81e91f5c62af8e5ba76',
                '0146217e08b8aa4515086edaf72bc264',
                '94a45749b7cad8a004a6a52458e4c43a',
            ],
        ];

        $container = [];

        $api = new MerchantApi(
            $this->client(json_encode($listResponse), 200, $container),
            self::MERCHANT_ID,
            self::SECRET
        );

        $result = $api->listInvoices();

        $this->assertInstanceOf(InvoiceCollection::class, $result);
        $this->assertSame(true, $result->valid());
    }

    public function testGetInvoice(): void
    {
        $getInvoiceResponse = [
            'order_id' => 'test-order-id',
            'amount' => '13.37000000',
            'currency' => 'usd',
            'status' => 'cancelled',
        ];

        $container = [];

        $api = new MerchantApi(
            $this->client(json_encode($getInvoiceResponse), 200, $container),
            self::MERCHANT_ID,
            self::SECRET
        );

        $result = $api->getInvoice('some-invoice-id');

        $this->assertInstanceOf(Invoice::class, $result);
        $this->assertSame(true, $result->partial());
        $this->assertSame(true, $result->valid());
    }

    public function testCreateInvoice(): void
    {
        $container = [];

        $invoiceResponse = $this->httpNotification();

        $api = new MerchantApi(
            $this->client(json_encode($invoiceResponse), 200, $container),
            self::MERCHANT_ID,
            self::SECRET
        );

        $result = $api->createInvoice(
            'item name',
            'bitcoin',
            13.37,
            'usd',
            'my-order-id',
            'item description',
            'https://success.url/page',
            'https://failed.url/page',
            '3',
            'en'
        );

        $this->assertInstanceOf(Invoice::class, $result);
        $this->assertSame(true, $result->full());
        $this->assertSame(true, $result->valid());
    }

    public function testHttpNotificationInvoice(): void
    {
        $notification = $this->httpNotification();

        $api = new MerchantApi(
            new Client(),
            self::MERCHANT_ID,
            self::SECRET
        );

        $result = $api->httpNotificationInvoice($notification);

        $this->assertInstanceOf(Invoice::class, $result);
        $this->assertSame(true, $result->valid());

        unset($notification['merchant_id']);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Merchant id does not match own (%s) vs ()',
                self::MERCHANT_ID
            )
        );
        $api->httpNotificationInvoice($notification);

        unset($notification['secret_hash']);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('HTTP notification data does not contain secret_hash key');
        $api->httpNotificationInvoice($notification);
    }

    public function testHttpNotificationInvoiceMissingSecretHash(): void
    {
        $notification = $this->httpNotification();
        unset($notification['secret_hash']);

        $api = new MerchantApi(
            new Client(),
            self::MERCHANT_ID,
            self::SECRET
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('HTTP notification data does not contain secret_hash key');
        $api->httpNotificationInvoice($notification);
    }

    public function testHttpNotificationInvoiceMissingMerchantId(): void
    {
        $notification = $this->httpNotification();
        $notification['merchant_id'] = 'wrongid';

        $api = new MerchantApi(
            new Client(),
            self::MERCHANT_ID,
            self::SECRET
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Merchant id does not match own (%s) vs (%s)',
                self::MERCHANT_ID,
                'wrongid'
            )
        );
        $api->httpNotificationInvoice($notification);
    }

    public function testStartPayment(): void
    {
        $api = new MerchantApi(
            new Client(),
            self::MERCHANT_ID,
            self::SECRET
        );

        $result = $api->startPayment(
            'item name',
            13.37,
            'usd',
            'my-order-id',
            'item description',
            'https://success.url/page',
            'https://failed.url/page',
            'en'
        );

        $url = parse_url($result);

        $this->assertSame(
            [
                'scheme' => 'https',
                'host' => 'api.cryptonator.com',
                'path' => '/api/merchant/v1/startpayment',
                'query' => 'merchant_id=b60d121b438a380c343d5ec3c2037564&item_name=item+name&order_id=my-order-id&item_description=item+description&invoice_amount=13.37&invoice_currency=usd&success_url=https%3A%2F%2Fsuccess.url%2Fpage&failed_url=https%3A%2F%2Ffailed.url%2Fpage&language=en',
            ],
            $url
        );
    }

    private function httpNotification(): array
    {
        return [
            'merchant_id' => 'b60d121b438a380c343d5ec3c2037564',
            'invoice_id' => 'ffa6706ff2127a749973072756f83c53',
            'invoice_created' => '1539792598',
            'invoice_expires' => '1539794398',
            'invoice_amount' => '13.37',
            'invoice_currency' => 'usd',
            'invoice_status' => 'unpaid',
            'invoice_url' => 'https://www.cryptonator.com/merchant/invoice/ffa6706ff2127a749973072756f83c53',
            'order_id' => 'my-order-id',
            'checkout_address' => '19u4RU9H8kcv3oPapNqSkk3GKGNvRrvkst',
            'checkout_amount' => '0.002082833526',
            'checkout_currency' => 'bitcoin',
            'date_time' => '1539794403',
            'secret_hash' => 'e657af0cb176de16650f3b0e4402eb424085283c',
        ];
    }
}
