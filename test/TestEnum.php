<?php

declare(strict_types=1);

namespace NeutronStars\Enum\Test;

use NeutronStars\Enum\Error\ValueError;
use NeutronStars\Enum\Test\Fixture\FooWithoutValueEnum;
use NeutronStars\Enum\Test\Fixture\FooWithValueIntEnum;
use NeutronStars\Enum\Test\Fixture\FooWithValueStringEnum;
use PHPUnit\Framework\TestCase;

class TestEnum extends TestCase
{
    public function testCallStaticEnumMethodIsNotNull(): void
    {
        $this->assertNotNull(
            FooWithoutValueEnum::FOO(),
            'Call static return empty instance.'
        );
    }

    public function testSameInstanceEnum(): void
    {
        $this->assertSame(
            FooWithValueStringEnum::FOO(),
            FooWithValueStringEnum::FOO(),
            'The instances are not identical.'
        );
    }

    public function testNotSameInstanceEnum(): void
    {
        $this->assertNotSame(
            FooWithValueStringEnum::FOO(),
            FooWithValueStringEnum::BAR(),
            'The instances are identical.'
        );
    }

    public function testGetKeyEnum(): void
    {
        $this->assertSame(
            'FOO',
            FooWithValueStringEnum::FOO()->key,
            'The key did not return FOO.'
        );
    }

    public function testGetValueEnum(): void
    {
        $this->assertSame(
            'Bar',
            FooWithValueStringEnum::BAR()->value,
            'The value did not return Bar.'
        );
    }

    public function testFromEnum(): void
    {
        $this->assertNotNull(
            FooWithValueStringEnum::from('FOO'),
            'The key did not return the FOO instance with from.'
        );
        $this->assertNotNull(
            FooWithValueStringEnum::from('Foo'),
            'The value did not return the FOO instance with from.'
        );
        $this->assertNotNull(
            FooWithValueStringEnum::from(1),
            'The index did not return the FOO instance with from.'
        );
    }

    public function testFromEnumWithError(): void
    {
        $this->expectException(ValueError::class);
        $this->assertNotNull(
            FooWithValueStringEnum::from('FOO_BAR'),
            'The key did not return the Value Error with from.'
        );
        $this->assertNotNull(
            FooWithValueStringEnum::from('foo_Bar'),
            'The value did not return the Value Error with from.'
        );
        $this->assertNotNull(
            FooWithValueStringEnum::from(0),
            'The index did not return the Value Error with from.'
        );
    }

    public function testTryFromEnum(): void
    {
        $this->assertNotNull(
            FooWithValueStringEnum::tryFrom('FOO'),
            'The key did not return the FOO instance with tryFrom.'
        );
        $this->assertNotNull(
            FooWithValueStringEnum::tryFrom('Foo'),
            'The value did not return the FOO instance with tryFrom.'
        );
        $this->assertNotNull(
            FooWithValueStringEnum::tryFrom(1),
            'The index did not return the FOO instance with tryFrom.'
        );
    }

    public function testTryFromPriorityEnum(): void
    {
        $this->assertSame(
            FooWithValueIntEnum::BAR(),
            FooWithValueIntEnum::tryFrom(1),
            'The value priority did not work.'
        );
        $this->assertSame(
            FooWithValueIntEnum::FOO(),
            FooWithValueIntEnum::tryFrom(2),
            'The value priority did not work.'
        );
    }

    public function testTryFromEnumWithError(): void
    {
        $this->assertNull(
            FooWithValueStringEnum::tryFrom('FOO_BAR'),
            'The key did not return null with tryFrom.'
        );
        $this->assertNull(
            FooWithValueStringEnum::tryFrom('foo_Bar'),
            'The value did not return null with tryFrom.'
        );
        $this->assertNull(
            FooWithValueStringEnum::tryFrom(0),
            'The index did not return null with tryFrom.'
        );
    }

    public function testGetSameCases(): void
    {
        $this->assertSame(
            FooWithoutValueEnum::cases(),
            [FooWithoutValueEnum::FOO(), FooWithoutValueEnum::BAR()],
            'The arrays are not identical.'
        );
    }

    public function testSerializeEnum(): void
    {
        $this->assertSame(
            'E:23:"FooWithoutValueEnum:FOO"',
            FooWithoutValueEnum::FOO()->serialize(),
            'The serialization is not valid.'
        );

        $this->assertSame(
            'E:26:"FooWithValueStringEnum:BAR"',
            FooWithValueStringEnum::BAR()->serialize(),
            'The serialization is not valid.'
        );
    }

    public function testGetUnserializeEnum(): void
    {
        $this->assertSame(
            FooWithoutValueEnum::tryFrom(unserialize(serialize(FooWithoutValueEnum::BAR()))),
            FooWithoutValueEnum::BAR(),
            'The serialization did not go well.'
        );
    }
}