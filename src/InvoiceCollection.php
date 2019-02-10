<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator;

use Okaruto\Cryptonator\Exceptions\InvoiceCollectionInvalidException;

/**
 * Class InvoiceCollection
 *
 * @package Okaruto\Cryptonator
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class InvoiceCollection implements InvoiceCollectionInterface
{
    /** @var MerchantApiInterface */
    private $api;

    /** @var array */
    private $data;

    /** @var null|bool */
    private $valid;

    /** @var null|array */
    private $invoices;

    /**
     * InvoiceCollection constructor.
     *
     * @param MerchantApiInterface $api  Merchant api
     * @param array                $data Data
     */
    public function __construct(MerchantApiInterface $api, array $data)
    {
        $this->data = $data;
        $this->api = $api;
    }

    /**
     * Returns invoice count
     *
     * @return int
     */
    public function count(): int
    {
        $this->valid(true);
        return $this->data['invoice_count'];
    }

    /**
     * Return whether collection contains valid data
     *
     * @param   bool $throw Should exception be thrown?
     *
     * @return bool
     */
    public function valid($throw = false): bool
    {
        if ($this->valid === null) {
            $this->valid = isset($this->data['invoice_count'], $this->data['invoice_list'])
                && is_int($this->data['invoice_count'])
                && array_reduce(
                    $this->data['invoice_list'],
                    /**
                     * Return if all given values are of type string
                     *
                     * @param bool  $carry    Carried value
                     * @param mixed $value    Given value
                     *
                     * @return bool
                     */
                    function (bool $carry, $value): bool {
                        return $carry && is_string($value);
                    },
                    true
                );
        }

        if (!$this->valid && $throw) {
            throw new InvoiceCollectionInvalidException($this->data);
        }

        return $this->valid;
    }

    /**
     * Return invoice list
     *
     * @return array
     */
    public function list(): array
    {
        $this->valid(true);
        return $this->data['invoice_list'];
    }

    /**
     * Return invoice by id
     *
     * @param string $invoiceId Invoice id
     *
     * @return Invoice
     */
    public function invoice(string $invoiceId): Invoice
    {
        $this->valid(true);
        $this->has($invoiceId, true);

        return $this->api->getInvoice($invoiceId);
    }

    /**
     * Returns whether invoice id exists in collection
     *
     * @param string $invoiceId Invoice id
     * @param bool   $throw     Should exception be thrown?
     *
     * @return bool
     * @throws \LogicException
     */
    public function has(string $invoiceId, $throw = false): bool
    {
        $this->valid(true);

        if ($this->invoices === null) {
            $this->invoices = array_flip($this->data['invoice_list']);
        }

        if ($throw && !isset($this->invoices[$invoiceId])) {
            throw new \LogicException(
                sprintf(
                    'Invoice with id (%s) not found in collection',
                    $invoiceId
                )
            );
        }

        return isset($this->invoices[$invoiceId]);
    }
}
