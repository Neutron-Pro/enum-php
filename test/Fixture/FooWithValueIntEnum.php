<?php

declare(strict_types=1);

namespace NeutronStars\Enum\Test\Fixture;

use NeutronStars\Enum\Enum;

/**
 * @method static self FOO()
 * @method static self BAR()
 * Class FooWithValueIntEnum
 * @package NeutronStars\Enum\Test\Fixture
 */
class FooWithValueIntEnum extends Enum
{
    public const FOO = 2;
    public const BAR = 1;
}