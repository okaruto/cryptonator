<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Endpoint;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Lmc\HttpConstants\Header;
use Okaruto\Cryptonator\Exceptions\JsonException;
use Okaruto\Cryptonator\Exceptions\ServerErrorException;
use Okaruto\Cryptonator\Hash\Generator;
use Okaruto\Cryptonator\Values;

/**
 * Class AbstractEndpoint
 *
 * @package Okaruto\Cryptonator\Endpoint
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
abstract class AbstractEndpoint implements EndpointInterface
{
    public const API_URL = 'https://api.cryptonator.com/api/merchant/v1/';
    private const USER_AGENT = 'Merchant.SDK/PHP';

    protected const API_TYPE_QUERY = 'query';
    protected const API_TYPE_POST = 'post';

    protected const API_ENDPOINT = '';
    protected const API_TYPE = '';

    /** @var ClientInterface */
    private $client;

    /** @var string */
    private $merchantId;

    /** @var string */
    private $secret;

    /** @var Values\ValuesInterface */
    private $values;

    /**
     * AbstractEndpoint constructor.
     *
     * @param ClientInterface        $client     HTTP client
     * @param string                 $merchantId Merchant id
     * @param string                 $secret     Secret
     * @param Values\ValuesInterface $values     Values
     */
    public function __construct(
        ClientInterface $client,
        string $merchantId,
        string $secret,
        Values\ValuesInterface $values
    ) {
        $this->client = $client;
        $this->merchantId = $merchantId;
        $this->secret = $secret;
        $this->values = $values;
    }

    /**
     * Send request to api endpoint
     *
     * @return array
     * @throws ServerErrorException
     * @throws JsonException
     */
    public function send(): array
    {
        $request = new Request(
            'POST',
            self::API_URL . static::API_ENDPOINT,
            [
                Header::USER_AGENT => self::USER_AGENT,
            ]
        );

        $formParams = array_merge(
            [
                Values\AbstractValues::VALUE_MERCHANT_ID => $this->merchantId,
            ],
            $this->values->array()
        );

        $formParams[Values\AbstractValues::VALUE_SECRET_HASH] = (new Generator($this->secret, $formParams))->hash();

        $query = [];

        if (static::API_TYPE === self::API_TYPE_QUERY) {
            $query[RequestOptions::QUERY] = $formParams;
        } elseif (static::API_TYPE === self::API_TYPE_POST) {
            $query[RequestOptions::FORM_PARAMS] = $formParams;
        }

        $response = $this->client->send(
            $request,
            array_merge(
                $query,
                [
                    RequestOptions::ALLOW_REDIRECTS => false,
                    RequestOptions::HTTP_ERRORS => false,
                ]
            )
        );

        $contents = $response->getBody()->getContents();

        if ($response->getStatusCode() >= 400) {
            throw new ServerErrorException(
                $response->getReasonPhrase(),
                $response->getStatusCode(),
                $contents
            );
        }

        $decodedContents = json_decode($contents, true);
        $jsonError = json_last_error();

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonException($contents, $jsonError);
        }

        return $decodedContents;
    }

    /**
     * Return a Generator instance seeded with secret and values
     *
     * @param array $values Values
     *
     * @return Generator
     */
    protected function seededGenerator(array $values): Generator
    {
        return new Generator($this->secret, $values);
    }

    /**
     * Return values object
     *
     * @return Values\ValuesInterface
     */
    protected function values(): Values\ValuesInterface
    {
        return $this->values;
    }
}
