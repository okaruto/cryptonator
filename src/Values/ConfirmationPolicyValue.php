<?php
declare(strict_types=1);

namespace Okaruto\Cryptonator\Values;

/**
 * Class ConfirmationPolicyValue
 *
 * @package Okaruto\Cryptonator\Values
 * @author  Okaruto Shirukoto <okaruto@protonmail.com>
 * @license http://opensource.org/licenses/MIT
 */
final class ConfirmationPolicyValue extends AbstractValue
{
    public const CONFIRMATION_POLICY_FAST = '0';
    public const CONFIRMATION_POLICY_NORMAL = '1';
    public const CONFIRMATION_POLICY_SLOW = '3';

    protected const ALLOWED_VALUES = [
        self::CONFIRMATION_POLICY_FAST,
        self::CONFIRMATION_POLICY_NORMAL,
        self::CONFIRMATION_POLICY_SLOW,
    ];
}
