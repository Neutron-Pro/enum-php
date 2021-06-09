<?php

declare(strict_types=1);

namespace NeutronStars\Enum\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use NeutronStars\Enum\Enum;

class EnumType extends Type
{
    public const NS_ENUM = 'ns_enum';

    public function getName(): string
    {
        return self::NS_ENUM;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return Types::STRING;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof Enum ? (string) $value : null;
    }
}