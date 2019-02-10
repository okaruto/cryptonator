<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Invoice;

/**
 * Class Dates
 *
 * @package Okaruto\Cryptonator\Invoice
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class Dates extends AbstractInvoiceData implements DatesInterface
{
    /** @var int */
    private $created;

    /** @var int */
    private $expires;

    /** @var int */
    private $dateTime;

    /**
     * Dates constructor.
     *
     * @param int $created
     * @param int $expires
     * @param int $dateTime
     */
    public function __construct(int $created, int $expires, int $dateTime)
    {
        $this->created = $created;
        $this->expires = $expires;
        $this->dateTime = $dateTime;
    }

    /**
     * Return invoice created data/time
     *
     * @return \DateTimeImmutable
     */
    public function created(): \DateTimeImmutable
    {
        $this->valid(true);
        return new \DateTimeImmutable(date(DATE_W3C, $this->created));
    }

    /**
     * Return invoice expires date/time
     *
     * @return \DateTimeImmutable
     */
    public function expires(): \DateTimeImmutable
    {
        $this->valid(true);
        return new \DateTimeImmutable(date(DATE_W3C, $this->expires));
    }

    /**
     * Return invoice date/time
     *
     * @return \DateTimeImmutable
     */
    public function dateTime(): \DateTimeImmutable
    {
        $this->valid(true);
        return new \DateTimeImmutable(date(DATE_W3C, $this->dateTime));
    }

    /**
     * Return collection of fields as boolean array
     *
     * @return array
     */
    protected function fields(): array
    {
        return [
            $this->created > 0,
            $this->expires > 0,
            $this->dateTime > 0
        ];
    }
}
