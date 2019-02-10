<?php
declare(strict_types=1);


namespace Okaruto\Cryptonator\Endpoint;

use GuzzleHttp\ClientInterface;
use Okaruto\Cryptonator\Values;

/**
 * Class GetInvoice
 *
 * @package Okaruto\Cryptonator\Endpoint
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class GetInvoice extends AbstractEndpoint
{
    protected const API_ENDPOINT = 'getinvoice';
    protected const API_TYPE = self::API_TYPE_QUERY;

    /**
     * GetInvoice constructor.
     *
     * @param ClientInterface         $client     HTTP client
     * @param string                  $merchantId Merchant id
     * @param string                  $secret     Secret
     * @param Values\GetInvoiceValues $values     Values
     */
    public function __construct(
        ClientInterface $client,
        string $merchantId,
        string $secret,
        Values\GetInvoiceValues $values
    ) {
        parent::__construct($client, $merchantId, $secret, $values);
    }
}
