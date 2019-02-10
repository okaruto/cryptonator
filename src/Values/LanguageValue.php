<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

/**
 * Class LanguageValue
 *
 * @package Okaruto\Cryptonator\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class LanguageValue extends AbstractValue
{
    public const LANGUAGE_EN = 'en';
    public const LANGUAGE_DE = 'de';
    public const LANGUAGE_ES = 'es';
    public const LANGUAGE_FR = 'fr';
    public const LANGUAGE_RU = 'ru';
    public const LANGUAGE_CN = 'cn';

    protected const ALLOWED_VALUES = [
        self::LANGUAGE_EN,
        self::LANGUAGE_DE,
        self::LANGUAGE_ES,
        self::LANGUAGE_FR,
        self::LANGUAGE_RU,
        self::LANGUAGE_CN,
    ];
}
