<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Endpoint;

use GuzzleHttp\ClientInterface;
use Okaruto\Cryptonator\Exceptions\HashInvalidException;
use Okaruto\Cryptonator\Hash\Validator;
use Okaruto\Cryptonator\Values;

/**
 * Class CreateInvoice
 *
 * @package Okaruto\Cryptonator\Endpoint
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class CreateInvoice extends AbstractEndpoint
{
    protected const API_ENDPOINT = 'createinvoice';
    protected const API_TYPE = self::API_TYPE_POST;

    /**
     * CreateInvoice constructor.
     *
     * @param ClientInterface            $client     HTTP client
     * @param string                     $merchantId Merchant id
     * @param string                     $secret     Secret
     * @param Values\CreateInvoiceValues $values     Values
     */
    public function __construct(
        ClientInterface $client,
        string $merchantId,
        string $secret,
        Values\CreateInvoiceValues $values
    ) {
        parent::__construct($client, $merchantId, $secret, $values);
    }

    /**
     * Send request to api endpoint
     *
     * @return array
     * @throws HashInvalidException
     */
    public function send(): array
    {
        $values = parent::send();

        $hash = $values['secret_hash'] ?? '';
        unset($values['secret_hash']);

        if (!(new Validator(parent::seededGenerator($values), $hash))->valid()) {
            throw new HashInvalidException();
        }

        $createValues = $this->values();

        // We need to augment the returned data to get a full invoice
        $values['order_id'] = $createValues->get(Values\CreateInvoiceValues::VALUE_ORDER_ID);
        $values['invoice_amount'] = (string)$createValues->get(Values\CreateInvoiceValues::VALUE_INVOICE_AMOUNT);
        $values['invoice_currency'] = $createValues->get(Values\CreateInvoiceValues::VALUE_INVOICE_CURRENCY)->value();
        $values['invoice_status'] = Values\InvoiceStatusValue::INVOICE_STATUS_UNPAID;
        $values['invoice_url'] = '';
        $values['date_time'] = (string)time();

        return $values;
    }
}
