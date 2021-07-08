<?php

declare(strict_types=1);

namespace NeutronStars\Enum\Normalizer;

use NeutronStars\Enum\Enum;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EnumNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /** @var string|Enum $className */
    private $className;

    /**
     * @param string|null $className
     * @throws NotNormalizableValueException
     */
    public function __construct(?string $className = null)
    {
        $this->className = $className ?? Enum::class;
        if ($this->className !== Enum::class
            && !is_subclass_of($this->className, Enum::class, true)) {
            throw new NotNormalizableValueException('Class ' . $this->className . ' is not supported !');
        }
    }


    public function supportsNormalization($data, string $format = null): bool
    {
        return is_a($data, Enum::class, true);
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return string|null
     */
    public function normalize($object, string $format = null, array $context = []): ?string
    {
        if ($object instanceof Enum) {
            return (string) $object;
        }
        return null;
    }

    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return is_a($type, Enum::class, true);
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     * @return object
     * @throws \ReflectionException
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return $this->className::from($data);
    }
}