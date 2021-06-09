<?php

declare(strict_types=1);

namespace NeutronStars\Enum\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use NeutronStars\Enum\Enum;

abstract class EnumType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return Types::STRING;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return ($value instanceof Enum) ? (string) $value : null;
    }
}