{% block title%}Functions{% endblock %}

{% block body%}

PHP comes with [hundreds](https://www.php.net/manual/en/funcref.php) of built in functions, to sort arrays, find the
length of strings, match regexes, or even [get the timestamp corresponding to midnight on Easter of a given
year](https://www.php.net/manual/en/function.easter-date.php), but you will inevitably want to define your own functions.
Function definitions look like this:

```php
function getGreeting(string $planetName): string
{
    return "Hello, $planetName.\n";
}
```

Notice the **type declarations**, `string` and `: string`. Strictly speaking these are optional, but you should add
them whenever you can. PHP is a *gradually typed* language, like TypeScript. However unlike Typescript, which does
type checking in the compiler, PHP applies type checking only when the relevant part of your program runs. Let's see
an example:

```php
<?php declare(strict_types=1);

function getGreeting(string $planetName): string
{
    return "Hello, $planetName.\n";
}

echo getGreeting('Magrathea');
echo getGreeting(42);
```

Running this, you should see something like:
```text
Hello, Magrathea.
PHP Fatal error:  Uncaught TypeError: Argument 1 passed to getGreeting() must be of the type string, int given, called in functions.php on line 9 and defined in functions.php:3
Stack trace:
#0 functions.php(9): getGreeting()
#1 {main}
  thrown in functions.php on line 3
```
The first part of the program ran fine, but attempting to pass an integer to a function that we've declared with a
string parameter was a fatal error and caused a crash. If we'd tried to return anything other than a string from inside
the function that would also be a fatal error.
{% endblock %}