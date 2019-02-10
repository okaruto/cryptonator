<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\ValueInvalidException;
use Okaruto\Cryptonator\Values\LanguageValue;
use PHPUnit\Framework\TestCase;

/**
 * Class ValueLanguageTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class ValueLanguageTest extends TestCase
{
    public function testValidLanguageValues(): void
    {
        $value = new LanguageValue(LanguageValue::LANGUAGE_EN);
        $this->assertSame(true, $value->valid());
        $this->assertSame('en', $value->value());

        $value = new LanguageValue(LanguageValue::LANGUAGE_DE);
        $this->assertSame(true, $value->valid());
        $this->assertSame('de', $value->value());

        $value = new LanguageValue(LanguageValue::LANGUAGE_ES);
        $this->assertSame(true, $value->valid());
        $this->assertSame('es', $value->value());

        $value = new LanguageValue(LanguageValue::LANGUAGE_FR);
        $this->assertSame(true, $value->valid());
        $this->assertSame('fr', $value->value());

        $value = new LanguageValue(LanguageValue::LANGUAGE_RU);
        $this->assertSame(true, $value->valid());
        $this->assertSame('ru', $value->value());

        $value = new LanguageValue(LanguageValue::LANGUAGE_CN);
        $this->assertSame(true, $value->valid());
        $this->assertSame('cn', $value->value());
    }

    public function testInvalidLanguageValue(): void
    {
        $value = new LanguageValue('se');

        $this->assertSame(false, $value->valid());
        $this->expectException(ValueInvalidException::class);
        $value->value();
    }
}
