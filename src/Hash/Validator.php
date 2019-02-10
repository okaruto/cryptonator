<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Hash;

/**
 * Class Validator
 *
 * @package Okaruto\Cryptonator\Hash
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class Validator
{
    /** @var Generator Generator */
    private $generator;

    /** @var string Hash */
    private $hash;

    /**
     * Validator constructor.
     *
     * @param Generator $generator Hash generator
     * @param string    $hash      Incoming hash
     */
    public function __construct(Generator $generator, string $hash)
    {
        $this->generator = $generator;
        $this->hash = $hash;
    }

    /**
     * Returns whether hash is valid
     *
     * @param bool $throw Should exception be thrown?
     *
     * @return bool
     */
    public function valid($throw = false): bool
    {
        $generatedHash = $this->generator->hash();
        $valid = $generatedHash === $this->hash;

        if (!$valid && $throw) {
            throw new \RuntimeException(
                sprintf(
                    'Hashes not matching: %s (generated) !== %s (provided)',
                    $generatedHash,
                    $this->hash
                )
            );
        }

        return $valid;
    }
}
