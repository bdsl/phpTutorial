# Classes Part 2

On the last page we wrote **Planet** class, and saved it in a file called **Planet.php**. Now we want to put that class
to work.

PHP works by executing whatever script we give it from beginning to end. It won't run anything inside a class unless
we that script tells it to, so every PHP program needs at least one line that isn't part of any class as an entry-point.
There is no equivalent to the `main` function of languages like C and Java.

By convention, and to follow the **PSR-1** coding standard, we always put the entry point in a separate file to the
class declaration.

Let's write a simple script to create a planet and print out its details. Since at the moment Planet is just a data
holder the script won't be too exiting.

Write the following in a file called start.php

```php
<?php declare(strict_types=1);

$planet = new Planet('Neptune', 0);

echo "Planet {$planet->getName()} has a population of {$planet->getPopulationSize()}.\n";
```

We can try running this now but it won't work just yet, because we need to link it up with `Planet.php`. When you type 
`php start.php` you should see `PHP Fatal error:  Uncaught Error: Class 'Planet' not found`.

## Linking files together

There are two main ways to link files together. The old way is **require_once**, and the new ways is **composer**. We'll
start with require_once, but for all but the simplest of scripts we will want to use composer.

### Require_once

Edit start.php to make it look like this:

```php
<?php declare(strict_types=1);

require_once 'Planet.php';

$planet = new Planet('Neptune', 0);

echo "Planet {$planet->getName()} has a population of {$planet->getPopulationSize()}.\n";
```

Run the script again, and you should now see `Planet Neptune has a population of 0.`. The require_once statement
tells PHP to process the contents of the given file as if it had been pasted in to the current script, ignoring
the `<?php` opening tag and the `declare`. The once part means that if we require the same file more than once PHP will
skip it on the second and subsequent times. That's what want for a class - once the class is loaded there's no need to
load it again, even if multiple parts of our program have to declare that they need that class.

But adding a `require_once` statement every time we need to use a class can quickly become tedious. It's what we all 
mostly did until around 2015, when the *Composer* dependency management tool became popular, even prompting a rare
mention for PHP in the ThoughtWorks Technology Radar.

### Composer

Composer is primarily a tool to help you add third party libraries and frameworks to your PHP projects, but since it
includes code to help us load the classes those libraries declare it makes sense to also use it to help us load our own
classes.

First check if you have composer installed - run `composer about`. On some systems it may be called `composer.phar` 
instead of composer. If you have it, you should see "Composer - Dependency Manager for PHP". If not, 
[download and install composer from getcomposer.org](https://getcomposer.org/download/), then come back to this page. I
suggest installing it to somewhere on your executable PATH, and naming it `composer` rather than `composer.phar`.



 