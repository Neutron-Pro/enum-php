<?php

declare(strict_types=1);

namespace NeutronStars\Enum;

use InvalidArgumentException;
use NeutronStars\Enum\Error\ValueError;
use ReflectionException;

/**
 * The class has inherited to create new enumerations.
 *
 *
 * @property string key;
 * @property mixed value;
 * Class Enum
 * @package NeutronStars\Enum
 */
abstract class Enum implements \Serializable
{
    /** @var Enum[][] */
    protected static $cases = [];

    /**
     * Name of the constant.
     * @var string
     */
    private $enumKey;

    /**
     * Value of the constant.
     */
    private $enumValue;

    /** @return mixed */
    public function __get($name)
    {
        switch ($name) {
            case 'key':
                return $this->enumKey;
            case 'value':
                return $this->enumValue;
        }
        throw new InvalidArgumentException('Invalid property: ' . static::class . '->' . $name);
    }

    public function __set($name, $value): void
    {
        throw new InvalidArgumentException('Can\'t set property: ' . static::class . '->' . $name);
    }

    public function __isset($name): bool
    {
        return $name === 'key' || $name === 'value';
    }

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
     * Set the name of the constant when the object is initialized.
     *
     * @param mixed $enumValue
     * @return $this
     */
    private function setEnumValue($enumValue): self
    {
        $this->enumValue = $enumValue;
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
     * @throws ValueError
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return static::from($name);
    }


    /**
     * @throws ReflectionException
     * @throws ValueError
     */
    public static function from($key): Enum
    {
        if (($enum = static::tryFrom($key)) !== null) {
            return $enum;
        }
        throw new ValueError('Can\'t find the value <' . $key . '> of ' . static::class . '.');
    }

    /**
     * Retrieves the instance of the enumeration according to its name.
     *
     * @param mixed $key
     * @return Enum|null
     * @throws ReflectionException
     */
    public static function tryFrom($key): ?Enum
    {
        $cases = static::cases();
        if (is_numeric($key) && !empty($cases[(int) $key - 1])) {
            return $cases[(int) $key - 1];
        }
        $value = null;
        $count = 0;
        foreach ($cases as $case) {
            if (($key instanceof self ? $key->key : $key) === $case->key) {
                return $case;
            }
            if ($key === $case->value) {
                $count++;
                $value = $case;
            }
        }
        return $count === 1 ? $value : null;
    }

    /**
     * Retrieves the list of constants from the enum.
     *
     * @return Enum[]
     * @throws ReflectionException
     */
    public static function cases(): array
    {
        if (empty(static::$cases[static::class])) {
            $reflect = new \ReflectionClass(static::class);
            $enum = [];
            foreach ($reflect->getConstants() as $key => $values) {
                $valuesParams = $values;
                if (!is_array($valuesParams)) {
                    $valuesParams = $valuesParams === null ? [] : [$valuesParams];
                }
                $enum[] = $reflect->newInstance(...($reflect->getConstructor() ? $valuesParams : []))
                    ->setEnumKey($key)
                    ->setEnumValue($values);
            }
            static::$cases[static::class] = $enum;
        }
        return static::$cases[static::class];
    }

    public function serialize(): string
    {
        $serialize = (new \ReflectionClass(static::class))->getShortName() . ':' . $this->key;
        return 'E:' . mb_strlen($serialize) . ':"' . $serialize . '"';
    }

    public function unserialize($data): void
    {
        $tab = mb_split(':', $data);
        $object = static::from(mb_substr($tab[count($tab)-1], 0, -1));
        $this->setEnumKey($object->key)->setEnumValue($object->value);
    }
}