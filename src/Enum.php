<?php

declare(strict_types=1);

namespace NeutronStars\Enum;

use ReflectionException;

/**
 * The class has inherited to create new enumerations.
 *
 * Class Enum
 * @package NeutronStars\Enum
 */
abstract class Enum
{
    /**
     * Name of the constant.
     * @var string
     */
    private $enumKey;

    /**
     * Set the name of the constant when the object is initialized.
     *
     * @param string $enumKey
     * @return $this
     */
    private function setEnumKey(string $enumKey): self
    {
        $this->enumKey = $enumKey;
        return $this;
    }

    /**
     * Compares if the instance of the enumeration is the same as in parameter.
     *
     * @param Enum $enum
     * @return bool
     */
    public function equals(Enum $enum): bool
    {
        return $this->enumKey === $enum->enumKey;
    }

    /**
     * Gets the name of the constant in a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->enumKey;
    }

    /**
     * Retrieves the instance of the selected enumeration.
     *
     * @throws ReflectionException
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return static::valueOf($name);
    }

    /**
     * Retrieves the instance of the enumeration according to its name.
     *
     * @param string $key
     * @return Enum|null
     * @throws ReflectionException
     */
    public static function valueOf(string $key): ?Enum
    {
        $reflect = new \ReflectionClass(static::class);
        if ($key === '_DEFAULT' && ($default = true) && $reflect->hasConstant($key)) {
            $key = (string) $reflect->getConstant('_DEFAULT');
        }
        if ($reflect->hasConstant($key)) {
            $values = $reflect->getConstant($key);
            if (!is_array($values)) {
                $values = $values === null ? [] : [$values];
            }
            return $reflect->newInstance(...$values)->setEnumKey($key);
        }
        return !($default ?? false) ? static::valueOf('_DEFAULT') : static::getFirstValue();
    }

    /**
     * Retrieves the list of constants from the enum.
     *
     * @return Enum[]
     * @throws ReflectionException
     */
    public static function values(): array
    {
        $reflect = new \ReflectionClass(static::class);
        $enum = [];
        foreach ($reflect->getConstants() as $key => $values) {
            if ($key !== '_DEFAULT') {
                if (!is_array($values)) {
                    $values = $values === null ? [] : [$values];
                }
                $enum[$key] = $reflect->newInstance(...$values)->setEnumKey($key);
            }
        }
        return $enum;
    }

    /**
     * @throws ReflectionException
     */
    public static function getFirstValue(): Enum
    {
        $reflect = new \ReflectionClass(static::class);
        if (($default = array_keys($reflect->getConstants())[0] ?? null) !== null) {
            return static::valueOf($default);
        }
        throw new ReflectionException(
            'Can\'t find the constant of _DEFAULT value in ' . static::class . '.'
        );
    }

    /**
     * Loops over each element of the enumeration and executes the consumer.
     *
     * <code>
     *   <php>
     *     CustomEnum::foreach(function ($name, $instance) {
     *       echo 'Constant name: ' . $name . ' | Instance of Constant: <pre>';
     *       print_r($instance);
     *       echo '</pre>';
     *     });
     *   </php>
     * </code>
     *
     * @param \Closure $consumer
     * @throws ReflectionException
     */
    public static function forEach(\Closure $consumer): void
    {
        foreach (static::values() as $key => $value) {
            $consumer($key, $value);
        }
    }
}