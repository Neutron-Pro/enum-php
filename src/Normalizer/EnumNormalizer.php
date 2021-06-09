<?php

declare(strict_types=1);

namespace NeutronStars\Enum\Normalizer;

use NeutronStars\Enum\Enum;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EnumNormalizer implements NormalizableInterface, DenormalizableInterface
{
    /** @var string $className */
    private $className;

    /**
     * EnumNormalizer constructor.
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

    /**
     * @param NormalizerInterface $normalizer
     * @param string|null $format
     * @param array $context
     * @return string|null
     */
    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = []): ?string
    {
        if ($normalizer instanceof Enum) {
            return (string) $normalizer;
        }
        return null;
    }

    /**
     * @param DenormalizerInterface       $denormalizer
     * @param array|string|int|float|bool $data
     * @param string|null                 $format
     * @param array                       $context
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data,
        string $format = null, array $context = []): object
    {
        return $this->className::valueOf($denormalizer);
    }
}