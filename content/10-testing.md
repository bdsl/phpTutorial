# Testing

If we want to work on even a moderately complex program over time, we need automated testing - manually testing 
everything every time we make a change would quickly become unsustainable.

## Installing PHPUnit

The leading test framework for PHP is Sebastian Bergmann's PHPUnit.

Since we already have composer set up for our project, we can use that to install PHPUnit in the vendor directory. Run:

```
composer require --dev phpunit/phpunit
```

Composer also automatically downloads and installs all the libraries that PHPUnit depends on, and the dependencies of
its dependencies, etc.

We use the `--dev` option because PHPUnit is a tool for developers, and not a library that our program would rely on
in production. If we wanted to prepare a copy of our program to install on a server, we would use the `--no-dev` option
of `composer install` to leave out PHPUnit.

When we ran the require command composer.json edited our `composer.json` file to record our updated requirements.
`composer.json` should now look like:

```json
{
    "autoload": {
        "psr-4": {
            "PhpAsASecondLanguage\\": "src/"
        }
    },
    "require-dev": {
        "phpunit/phpunit": "^9.0"
    }
}
``` 

The last major release of PHPUnit was 9.0, so composer has assumed we will always want whatever the latest PHPUnit
release in the 9 series is. The 10 series is not expected to be compatible with code written for PHPUnit 9, so composer
won't install that unless we edit composer json. Composer works best with dependencies that use *semantic versioning*, 
aka semver.

Composer has also created a new file for us, `composer.lock`. This has metadata about the exact versions of the packages
installed. At the time of writing it shows me that PHPUnit is at version 9.0.1, and I can see the details of 29 other
packages that have been installed because PHPUnit depends on them directly or indirectly. The `composer show` command
will output the list of installed packages in a much more consice format.

## Writing a test

Let's write our first test. Create a `test` subdirectory next to `src`, and write the following in `test/PlanetTest.php` 

```php
<?php declare(strict_types=1);

namespace PhpAsASecondLanguage;

use PHPUnit\Framework\TestCase;

final class PlanetTest extends TestCase
{
    private Planet $SUT; // SUT = Subject Under Test

    public function setUp(): void
    {
        $this->SUT = new Planet('planet name', 0);
    }

    public function test_it_can_accept_immigrant(): void
    {
        $this->assertSame(0.0, $this->SUT->getPopulationSize());
        $this->SUT->receiveImmigrant();
        $this->assertSame(1.0, $this->SUT->getPopulationSize());
    }
}
```

The new keyword here is `extends`. This means that our class is an extension, or subclass of PHPUnit's `TestCase` class,
which is how PHPUnit is designed to be used. If `TestCase` has been marked `final` we wouldn't be able to extend it.

If you're not on PHP 7.4, remember to remove the `Planet` property type for the SUT, and replace it with a docbloc as we
did for the properties of Planet itself.

It's prudent to see a test fail at least once before believing what it says when it passes. To make it fail, comment out
`$this->populationSize++;` in `src/Planet.php`:

`// $this->populationSize++;`

Now run the PHPUnit command:

```shell script
vendor/bin/phpunit test
```

This will search for any filenames ending in `Test.php` in the test directory. In each test case any public function
whose name starts with `test` is considered a test. For every test PHPUnit creates an instance of the class, calls the
setup function, then calls the test function, records the results, and then throws away the object. So if we had two test
it would run the set up function twice. If an object is referenced only by garbage it is garbage, so when the test case
object is thrown away the Planet is thrown away too, and any mutations to the planet will not affect the next test.

The output from PHPUnit should look like:

```text
PHPUnit 9.0.1 by Sebastian Bergmann and contributors.

F                                                                   1 / 1 (100%)

Time: 36 ms, Memory: 4.00 MB

There was 1 failure:

1) PhpAsASecondLanguage\PlanetTest::test_it_can_accept_immigrant
Failed asserting that 0.0 is identical to 1.0.

/tmp/composerPlayground/test/PlanetTest.php:20

FAILURES!
Tests: 1, Assertions: 2, Failures: 1.
```

Fix the Planet class putting the increment back in, and re-run the PHPUnit command. We should now see some happier 
output:

```text
PHPUnit 9.0.1 by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: 35 ms, Memory: 4.00 MB

OK (1 test, 2 assertions)
```

Writing tests is a huge topic, which we can't cover in detail here. PHPUnit has excellent 
[official documentation](https://phpunit.readthedocs.io/en/9.0/index.html). You might choose to do 
Test Driven Development (TDD) / Behaviour Driven Development (BDD) and write your tests before writing the 
production code that they cover. 

Some other major test frameworks for PHP are [PHPSpec](http://www.phpspec.net/en/stable/) and 
[Behat](https://docs.behat.org/en/latest/), which are both designed around the BDD approach, which
uses the language of *executable specifications* rather than tests. The major difference is that in PHPSpec, as with 
PHPUnit, you code in PHP. In Behat you code in a separate language called `gherkin`, designed to be readable by project
stakeholders who haven't been trained in programming.

