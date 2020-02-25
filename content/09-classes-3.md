# Classes Part 3

## Static methods

Not all the methods on a class have to run in the context of an object. Methods that work without a `$this` object 
instance are called static methods. Let's add a static method to the Planet class in `src/Planet.php`:

```php
<?php declare(strict_types=1);

namespace PhpAsASecondLanguage;

final class Planet
{
    private string $name;

    private float $populationSize;

    public function __construct(string $name, float $populationSize) 
    {
        $this->name = $name;
        $this->populationSize = $populationSize;
    }

   public function getName(): string
   {
       return $this->name;
   }

   public function getPopulationSize(): float
   {
       return $this->populationSize;
   }

   public static function earth(): self
   {
       return new self('Earth', 7.7 * 10**9);
   }
}
```

<!-- 
  Where is self officially defined? It isn't listed at https://www.php.net/manual/en/reserved.keywords.php . Only
  mentioned in passing at https://www.php.net/manual/en/language.oop5.basic.php . 
  -->

The `self` keyword refers to whatever class it's written in. It's more convenient to write `self` than to repeat 
`Planet` many times.

And let's edit start.php:

```php
<?php declare(strict_types=1);

namespace PhpAsASecondLanguage;

require_once __DIR__. '/vendor/autoload.php';

$planet = Planet::Earth();
echo "Planet {$planet->getName()} has a population of {$planet->getPopulationSize()}.\n";
```

The double colon is officially called the **Scope Resolution Operator**. It access properties and methods of classes
without going through an object. In this case our method returns an instance of the class, but it could
do anything.

## Object Identity

A PHP variable can't actually hold an object - instead it holds an **object identifier**, also known as a **reference**.

To objects created the same way, with the same properties will have distinct identities. But if one object is created
and then its assigned to two variables, they will both refer hold identifiers for the same object. This becomes 
important when we make our objects mutable. This extra complexity is a good reason to prefer immutable objects, but
we will need mutability at times.

Let's add a function to change the world - edit `src/Planet.php` again, adding the following function inside the class:

```php
   public function receiveImmigrant(): void
   {
       $this->populationSize++;
   }
```

`void` is the return type for functions that don't actually return any information.

Let's write a script that illustrates identities. Enter the following in 'identities.php'
```php
<?php declare(strict_types=1);

namespace PhpAsASecondLanguage;

require_once __DIR__. '/vendor/autoload.php';

$mercury = new Planet('Mercury', 0);
$secondMercury = new Planet('Mercury', 0);
$theSameMercury = $mercury;

echo "Mercury is equal to second Mercury:\n";
var_dump($mercury == $secondMercury);
echo \PHP_EOL;

echo "But Mercury is not **identical** to second Mercury:\n";
var_dump($mercury === $secondMercury);
echo \PHP_EOL;

echo "Mercury is equal **and** identical to the same Mercury:\n";
var_dump($mercury == $theSameMercury);
var_dump($mercury === $theSameMercury);
echo \PHP_EOL;

$mercury->receiveImmigrant();

echo "Population of Mercury: {$mercury->getPopulationSize()}.\n";
echo "Population of second Mercury: {$secondMercury->getPopulationSize()}.\n";
echo "Population of the same Mercury: {$theSameMercury->getPopulationSize()}.\n";
```

We see that `$mercury` and `$theSameMercury` are just two names for the same object, while `$secondMercury` is an 
entirely separate object with its own properties, lifecycle, hopes and dreams.

If we use or write a function that accepts an object as a parameter, or returns an object, it's important to be aware
that PHP doesn't make a copy of the object - it just copies the identifier. This means that code within and without
the function can access and potentially change the same object. It's an important part of how communication happens
between the parts of a PHP program, but it can easily get confusing if not managed carefully.