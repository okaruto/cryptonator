<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator;

/**
 * Interface InvoiceCollectionInterface
 *
 * @package Okaruto\Cryptonator
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
interface InvoiceCollectionInterface
{
    /**
     * Return whether collection contains valid data
     *
     * @param   bool $throw Should exception be thrown?
     *
     * @return bool
     */
    public function valid($throw = false): bool;

    /**
     * Returns invoice count
     *
     * @return int
     */
    public function count(): int;

    /**
     * Return invoice list
     *
     * @return array
     */
    public function list(): array;

    /**
     * Returns whether invoice id exists in collection
     *
     * @param string $invoiceId Invoice id
     *
     * @return bool
     */
    public function has(string $invoiceId): bool;

    /**
     * Return invoice by id
     *
     * @param string $invoiceId Invoice id
     *
     * @return Invoice
     */
    public function invoice(string $invoiceId): Invoice;
}
