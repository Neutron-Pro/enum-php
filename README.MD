# Enum library for PHP 7.1 or more.

## Installation:

```
composer require neutronstars/enum
```

---

## How create an Enum class:

### Method 1

```php
/**
 * @method static self ONE()
 * @method static self TWO()
 * @method static self THREE()
 */
class MyEnum extends \NeutronStars\Enum\Enum
{
   public const ONE = null;
   public const TWO = null;
   public const THREE = null;
}
```

This enum does not require a constructor. We simply create a list of constants that have no value other than their name.

### Method 2

```php
/**
 * @method static self ONE()
 * @method static self TWO()
 * @method static self THREE()
 */
class MyEnum extends \NeutronStars\Enum\Enum
{
   public const ONE   = 1;
   public const TWO   = 2;
   public const THREE = 3;
   
   /** @var int $value */
   private $value;
   
   public function __construct(int $value)
   {
     $this->value = $value;
   }
   
   public function getValue(): int
   {
     return $this->value;
   }
}
```

This enum must have a constructor with a parameter (of type integer in this example but it is possible to put other type).

### Method 3

```php
/**
 * @method static self ONE()
 * @method static self TWO()
 * @method static self THREE()
 */
class MyEnum extends \NeutronStars\Enum\Enum
{
   public const ONE   = [1, 'One'];
   public const TWO   = [2, 'Two'];
   public const THREE = [3, 'Three'];
   
   /** @var int $value */
   private $value;
   
   /** @var string $name */
   private $name;
   
   public function __construct(int $value, string $name)
   {
     $this->value = $value;
     $this->name = $name;
   }
   
   public function getValue(): int
   {
     return $this->value;
   }
   
   public function getName(): string
   {
     return $this->name;
   }
}
```

This enum must have a constructor with as many parameters as there are values in the largest array in the list of constants.

---

## Use an Enum class:

### Loop over all the constants of an enum.

```php
foreach (MyEnum::values() as $name => $instance) {
  echo $name . ' = ' . $instance->getValue();
}
// OR
MyEnum::forEach(function ($name, $instance) {
  echo $name . ' = ' . $instance->getValue();
});
```

- Result:

```
ONE = 1
TWO = 2
THREE = 3
```

### Get instance of an enum

```php
$two = MyEnum::TWO();

echo $two;
echo $two->getName();
echo $two->getValue();
```

- Result:

```
TWO
Two
2
```

### Get instance of an enum from a string

```php
$three = MyEnum::valueOf('THREE');

echo $three;
echo $three->getName();
echo $three->getValue();
```

- Result:

```
THREE
Three
3
```

### Compare the instances of an enum

```php
$value = MyEnum::valueOf($_GET['number']);
if ($value->equals(MyEnum::ONE())) {
  echo 'The number is ONE !';
}
```

- Result:

```
if $_GET['number] is ONE then 'The number is ONE !'
else nothing.
```

## Default enum value:

It is possible to create a constant to retrieve the value of an enumeration if it is not found.

```php
/**
 * @method static self _DEFAULT()
 * @method static self ONE()
 * @method static self TWO()
 * @method static self THREE()
 */
class MyEnum extends \NeutronStars\Enum\Enum
{
   public const _DEFAULT = 'TWO';

   public const ONE = null;
   public const TWO = null;
   public const THREE = null;
}
```

### Get the value of _DEFAULT

```php
echo 'Default value: ' . MyEnum::_DEFAULT();
```

- Result:

```
Default value: TWO
```

### Get the value of _DEFAULT with the valueOf function

```php
echo 'Default value: ' . MyEnum::valueOf('_DEFAULT');
// OR
echo 'Default value: ' . MyEnum::valueOf('A key that does not exist.');
```

- Result:

```
Default value: TWO
```