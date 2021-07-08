<?php

declare(strict_types=1);

namespace NeutronStars\Enum\Test\Fixture;

use NeutronStars\Enum\Enum;

/**
 * @method static self FOO()
 * @method static self BAR()
 * Class FooWithoutValueEnum
 * @package NeutronStars\Enum\Test\Fixture
 */
class FooWithoutValueEnum extends Enum
{
    public const FOO = null;
    public const BAR = null;
}