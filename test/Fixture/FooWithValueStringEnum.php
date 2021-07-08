<?php

declare(strict_types=1);

namespace NeutronStars\Enum\Test\Fixture;

use NeutronStars\Enum\Enum;

/**
 * @method static self FOO()
 * @method static self BAR()
 * Class FooWithValueStringEnum
 * @package NeutronStars\Enum\Test\Fixture
 */
class FooWithValueStringEnum extends Enum
{
    public const FOO = 'Foo';
    public const BAR = 'Bar';
}