# Variables

Variables in PHP always have a dollar sign `$` at the start of their names, and you declare a variable by assigning a
value to it. PHP *interpolates* double-quoted strings with variables. Edit hello.php to use a variable:

```php
<?php declare(strict_types=1);

$planet = "earth";

echo "Hello, $planet.\n";

```

You can probably guess what this will do when you run it on your command line or serve it to your browser.

# Arrays and loops

PHP has a very versatile built-in type called `array`. You're unlikely to find much PHP code that doesn't use arrays
extensively, but they are easy to overuse at the cost of other more expressive types. Despite the name, a PHP `array`
isn't really an *array* as you may know it from other languages. A PHP array is an **ordered iterable dictionary, with keys
and values**. The keys may be strings or integers, and by default will be sequential integers starting at zero.

An array is not an object in PHP - we will get on to objects later.

Let's edit our script to declare an array and iterate through it:

```php
<?php declare(strict_types=1);

$planets = ['Mercury', 'Venus', 'Earth', 'Mars', 'Jupiter', 'Saturn', 'Uranus', 'Neptune'];

foreach ($planets as $planet) {
    echo "Hello, $planet.\n";
}

$dwarfPlanet = 'Pluto';
echo "Hello, $dwarfPlanet.\n";
```

If you run this you should see:

```shell script
$ php hello.php 
Hello, Mercury.
Hello, Venus.
Hello, Earth.
Hello, Mars.
Hello, Jupiter.
Hello, Saturn.
Hello, Uranus.
Hello, Neptune.
Hello, Pluto.

```

`foreach` assigns each value from the array to the `$planet` variable in turn. We edit the script to ask it to give us 
the numeric keys that were implicitly set on line 3:

```php
<?php declare(strict_types=1);

$planets = ['Mercury', 'Venus', 'Earth', 'Mars', 'Jupiter', 'Saturn', 'Uranus', 'Neptune'];

foreach ($planets as $number => $planet) {
    echo "Hello, $planet, you are planet number $number.\n";
}

$dwarfPlanet = 'Pluto';
echo "Hello, $dwarfPlanet.\n";
```

The PHP manual lists [81 functions for manipulating arrays](https://www.php.net/manual/en/ref.array.php). For now let's
just try one: [natsort](https://www.php.net/manual/en/function.natsort.php). Add new line before `foreach`:

```php
natsort($planets);
```

Re-run the script - the planets are now listed in alphabetical order. But notice that the array keys have not changed - 
Mercury is still planet number `0`, it's just that `0` now happens to come after `3`. PHP array keys can come in any
order.
