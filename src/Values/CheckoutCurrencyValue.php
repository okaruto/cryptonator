<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

/**
 * Class CheckoutCurrencyValue
 *
 * @package Okaruto\Cryptonator\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class CheckoutCurrencyValue extends AbstractValue
{
    public const CHECKOUT_CURRENCY_BITCOIN = 'bitcoin';
    public const CHECKOUT_CURRENCY_BITCOINCASH = 'bitcoincash';
    public const CHECKOUT_CURRENCY_ETHEREUM = 'ethereum';
    public const CHECKOUT_CURRENCY_ETHEREUMCLASSIC = 'ethereumclassic';
    public const CHECKOUT_CURRENCY_LITECOIN = 'litecoin';
    public const CHECKOUT_CURRENCY_DASH = 'dash';
    public const CHECKOUT_CURRENCY_ZCASH = 'zcash';
    public const CHECKOUT_CURRENCY_DOGECOIN = 'dogecoin';
    public const CHECKOUT_CURRENCY_PEERCOIN = 'peercoin';
    public const CHECKOUT_CURRENCY_BYTECOIN = 'bytecoin';
    public const CHECKOUT_CURRENCY_EMERCOIN = 'emercoin';
    public const CHECKOUT_CURRENCY_MONERO = 'monero';

    protected const ALLOWED_VALUES = [
        self::CHECKOUT_CURRENCY_BITCOIN,
        self::CHECKOUT_CURRENCY_BITCOINCASH,
        self::CHECKOUT_CURRENCY_ETHEREUM,
        self::CHECKOUT_CURRENCY_ETHEREUMCLASSIC,
        self::CHECKOUT_CURRENCY_LITECOIN,
        self::CHECKOUT_CURRENCY_DASH,
        self::CHECKOUT_CURRENCY_ZCASH,
        self::CHECKOUT_CURRENCY_DOGECOIN,
        self::CHECKOUT_CURRENCY_PEERCOIN,
        self::CHECKOUT_CURRENCY_BYTECOIN,
        self::CHECKOUT_CURRENCY_EMERCOIN,
        self::CHECKOUT_CURRENCY_MONERO,
    ];
}
