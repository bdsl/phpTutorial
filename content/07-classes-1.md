# Classes and Objects

PHP supports class-based object oriented programming, heavily influenced by Java and similar languages. This is
different to the prototype based OO in JavaScript.

In the sort of PHP code I write almost 100% of the code in a project is in classes - some classes are used to make
objects, and others may just be convenient wrappers around groups of functions.

In PHP every object is an **instance** of a class, so you have to have a class before you can have an object. Let's write
a class to let us make Planet objects. How to write classes changed a bit in PHP 7.4. Enter the
following in a file called `Planet.php`:

```php
<?php declare(strict_types=1);

namespace AModeratelyShortPhpTutorial;

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
}
```

## Older PHP Versions

`name` and `populationSize` are the properties of the class, and they have `string` and `float` types respectively.
Before 7.4 PHP didn't allow us to specify types for properties. We still want to know what types of values we intend to
put in the properties, so we use a **DocBlock** instead. If you don't have 7.4 yet, change the property declarations
to:

```
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $populationSize;
```

These DocBlocks are ignored by the PHP engine, but they are very useful for us, and many tools and IDEs will read them.
The code inside the docblock is written in the [PHPDoc](https://docs.phpdoc.org/latest/references/phpdoc/index.html)
language.

## Running the code

Run `php Planet.php`. You should see no output - a class by itself doesn't do anything. We will write code to use this
class on the next page.

## What's in the class

Let's read through the class from top to bottom.

* The entire file is in a **namespace**. This is useful to help distinguish our code from other people's code, and
to distinguish between submodules when our program gets bigger. We will keep all our code in this namespace. The
namespace is effectively a prefix, so the full name of the class is ``\AModeratelyShortPhpTutorial\Planet``.

* Planet is a **final** class. This prevents any other classes being written as *subclasses* of Planet. Subclassing is
beyond the scope of this tutorial, but for now we can say that it adds significant complexity, and if we don't need it
we should probably avoid it. It's therefore a good practice to make classes final by default - we can always delete the
word final if we ever find we do need to make a subclasses of Planet.

* Planet has `name` and `populationSize` **properties**. When we create Planet objects every object will have its own copy
of these properties. The properties have `private` **visibility** - that means that the properties can only be directly read
or written by code within the Planet class.

    In the PHP 7.4 code they are **typed properties**, so PHP will
do a type check at run time whenever we assign values to the properties, and it will only allow us to assign strings of
text and and floating point numbers - attempting to assign anything else would cause a fatal error.

    We would also get a fatal error if we tried to read these typed properties before assigning values to them.

* Next we have three class **functions**, also known as methods. These all have `public` visibility, which means we can 
call them from anywhere.

    Functions whose names start with `__` are considered **Magic Methods** in PHP - they have special meanings given by the
language. `__construct` is the **Constructor**, and will be automatically called whenever we create a Planet object with
the `new` keyword.

    Finally we have our two *getter* functions. Since the properties are private, these public functions are needed to allow
code outside the class to read the properties. It's verbose, but it's a lot easier to understand what's happening in a big project
with a class like this than it would be if the properties were public and code from lots of other places could be
writing to them.

    These functions will be run with a given object instance of the class. The `$this` variable will refer to that
    object. We use the arrow `->` operator to access the properties and methods of any object.

    Having getters also means that if we later want to change the class - perhaps to replace the
`$populationSize` property with an array that holds details of every person on the planet - we can edit the code inside
the getter function and make it return the size of the array. Code that uses this class wouldn't have to be
affected by the change. Changes tend to ripple through a codebase, and one of the most important things to do when
choosing how to write code is anticipating types of future changes, and putting barriers in place to limit the spread of
those changes.

If you know JavaScript, you can think of a class with public and private parts as serving a similar purpose to a
JavaScript module that exports some but not all of its symbols.