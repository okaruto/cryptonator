<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Endpoint;

use GuzzleHttp\ClientInterface;
use Okaruto\Cryptonator\Values;

/**
 * Class ListInvoices
 *
 * @package Okaruto\Cryptonator\Endpoint
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class ListInvoices extends AbstractEndpoint
{
    protected const API_ENDPOINT = 'listinvoices';
    protected const API_TYPE = self::API_TYPE_QUERY;

    /**
     * ListInvoices constructor.
     *
     * @param ClientInterface           $client
     * @param string                    $merchantId
     * @param string                    $secret
     * @param Values\ListInvoicesValues $values
     */
    public function __construct(
        ClientInterface $client,
        string $merchantId,
        string $secret,
        Values\ListInvoicesValues $values
    ) {
        parent::__construct($client, $merchantId, $secret, $values);
    }
}
