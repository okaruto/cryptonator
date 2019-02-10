<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\NoExportKeysDefinedException;
use Okaruto\Cryptonator\Exceptions\ValuesInvalidException;
use Okaruto\Cryptonator\Values\AbstractValues;
use PHPUnit\Framework\TestCase;

class AbstractValuesTest extends TestCase
{
    public function testValuesInvalid(): void
    {
        $class = new class(['one' => 1]) extends AbstractValues
        {
            protected const MANDATORY_KEYS = ['one'];
            protected const EXPORT_KEYS = ['one'];

            protected function validate(): bool
            {
                return false;
            }
        };

        $this->expectException(ValuesInvalidException::class);
        $class->array();
    }

    public function testArray(): void
    {
        $class = new class(['one' => 1, 'two' => '2', 'three' => 3.0]) extends AbstractValues
        {
            protected const MANDATORY_KEYS = ['one', 'two', 'three'];
            protected const EXPORT_KEYS = ['one', 'two', 'three'];

            protected function validate(): bool
            {
                return true;
            }
        };

        $this->assertEquals(['one' => 1, 'two' => '2', 'three' => 3.0], $class->array());
    }

    public function testArrayExcessKeys(): void
    {
        $class = new class(['one' => 1, 'two' => 2, 'three' => 3, 'four' => 4]) extends AbstractValues
        {
            protected const MANDATORY_KEYS = ['one'];
            protected const EXPORT_KEYS = ['one', 'two', 'three'];

            protected function validate(): bool
            {
                return true;
            }
        };

        $this->assertEquals(['one' => 1, 'two' => 2, 'three' => 3], $class->array());
    }
}
