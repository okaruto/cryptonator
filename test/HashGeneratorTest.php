<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Tests;

use Okaruto\Cryptonator\Exceptions\InsufficientValuesException;
use Okaruto\Cryptonator\Exceptions\SecretHashIncludedException;
use Okaruto\Cryptonator\Hash;
use PHPUnit\Framework\TestCase;

/**
 * Class HashGeneratorTest
 *
 * @package Okaruto\Cryptonator\Tests
 * @license http://opensource.org/licenses/MIT
 */
class HashGeneratorTest extends TestCase
{
    private const SECRET = 'MYSECRET';
    private const VALUES =
        [
            'first' => 'one',
            'second' => 'two',
            'third' => 'three',
        ];

    private const VALID_HASH = 'bae7fc4ec52708301516a3022e57e08716aef143';

    public function testHashGeneration(): void
    {
        $generator = new Hash\Generator(self::SECRET, self::VALUES);

        $this->assertSame(self::VALID_HASH, $generator->hash());
    }

    public function testInsufficientValuesException(): void
    {
        $generator = new Hash\Generator(self::SECRET, []);

        $this->expectException(InsufficientValuesException::class);
        $generator->hash();
    }

    public function testSecretHashIncludedException(): void
    {
        $generator = new Hash\Generator(
            self::SECRET,
            array_merge(
                self::VALUES,
                ['secret_hash' => self::VALID_HASH]
            )
        );

        $this->expectException(SecretHashIncludedException::class);
        $generator->hash();
    }
}
