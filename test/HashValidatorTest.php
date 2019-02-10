<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Hash;
use PHPUnit\Framework\TestCase;

/**
 * Class HashValidatorTest
 *
 * @package Okaruto\Cryptonator\Hash
 * @license http://opensource.org/licenses/MIT
 */
class HashValidatorTest extends TestCase
{
    private const SECRET = 'MYSECRET';
    private const VALUES =
        [
            'first' => 'one',
            'second' => 'two',
            'third' => 'three',
        ];

    private const VALID_HASH = 'bae7fc4ec52708301516a3022e57e08716aef143';
    private const INVALID_HASH = 'e9a01d04ebe58f51e4291adee6768ce754d155d5';

    public function testValidHash(): void
    {
        $generator = new Hash\Generator(self::SECRET, self::VALUES);
        $validator = new Hash\Validator($generator, self::VALID_HASH);

        $this->assertSame(true, $validator->valid());
    }

    public function testInvalidHash(): void
    {
        $generator = new Hash\Generator(self::SECRET, self::VALUES);
        $validator = new Hash\Validator($generator, self::INVALID_HASH);

        $this->assertSame(false, $validator->valid());

        $this->expectException(\RuntimeException::class);
        $validator->valid(true);
    }
}
