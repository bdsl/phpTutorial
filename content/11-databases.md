# Databases

PHP applications often connect to databases. This is even harder to avoid in PHP than it would be in other languages
you can run on a web server like JS, Java, or C#, because PHP has a *shared-nothing* architecture. That means that the
code dealing with each request runs in isolation, and does not share any objects or variables with other requests. At
the end of the request-response cycle all stack frames are unwound and all objects become garbage. 

So if your program needs to persist anything from one page to the next, a database is a natural choice.

For simplicity, we will use [SQLite](https://sqlite.org/index.html). This is not a database server that you connect to, 
but a full featured SQL database engine supplied as a C library, and available as an add-on module for PHP, and the
world's most widely deployed DB engine. An SQLite database is just a file.

The details of SQL, the programming language for defining and querying databases, are beyond
the scope of this tutorial. We will see some SQL code, but as far as PHP is concerned they are just strings to send to 
the database engine.

## Install the SQLite PHP Module

We will use our SQLite database via PHP's PHP Data Objects (PDO) extension, which provides a consistent interface for
accessing many different DB types.

First check if the necessary PHP modules are installed. Run `php -i | grep sqlite`. If you have the module set up,
you should see a line like "PDO drivers => sqlite". There may be other drivers listed alongside sqlite.

If you don't have the PDO SQLite module, how to install it will depend on your OS and how you installed PHP.

### Linux

If you installed PHP through your package manager, there should be an SQLite module available in the same place. Make
sure you get the module that matches your PHP version number. For instance, on Debian or Ubuntu search your repository
with: 

`apt-cache search php | grep sqlite`

Once you've found the package name, e.g. `php7.4-sqlite3` install it with a command such as 

`sudo apt install php7.4-sqlite3`.

### Mac

If you installed PHP via homebrew, I think will automatically have come with SQLite built in and enabled.

### Windows

If you installed PHP as part of *XAMPP* this should have SQLite enabled by default.

## Creating a database

First, let's write a PHP script `src/create-database.php` to create a new database with one table:
```php
<?php declare(strict_types=1);

namespace AModeratelyShortPhpTutorial;

use PDO;

$filename =__DIR__ . "/database.sqlite";

file_put_contents($filename, '');

$connection = new PDO("sqlite:" . $filename);

$connection->query('
    CREATE TABLE planets (
        id INTEGER PRIMARY KEY,
        name text,
        population_size INTEGER
    );
'
);
```

Run the script with `php create-database.php`. It should create a new binary file `database.sqlite`.

`file_put_contents` writes a string to a file, overwriting the file if it already exists. We're using here to create
a completely empty file.

The `PDO` class is supplied by the [PDO extension](https://www.php.net/manual/en/intro.pdo.php). A PDO object represents
a connection to a database, and allows us to send it queries and get back results. When we call the
[PDO constructor](https://www.php.net/manual/en/pdo.construct.php) we pass it a string holding details of the database
we want to connect to, known as a Data Source Name or *DSN*. For SQLite the DSN consists of '`sqlite:`' followed by an
absolute file path.

## Querying the database

Let's write a very small program to put the planets in the database, and let us view info about any planet. First we
will need a class that can insert all the planets. Make a file `src/PlanetStore.php`

```php
<?php declare(strict_types=1);

namespace AModeratelyShortPhpTutorial;

use PDO;

final class PlanetStore
{
    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }
    
    public function storePlanets(): void
    {
        $statement = $this->connection->prepare('INSERT INTO planets (name, population_size) values (?, ?);');
        foreach ($this->generatePlanets() as $planet) {
            $statement->execute([$planet->getName(), $planet->getPopulationSize()]);        
        }
    }

    /** @return Planet[] */
    private function generatePlanets(): array
    {
        return [
            new Planet('Mercury', 0),
            new Planet('Venus', 0),
            new Planet('Earth', 7.7 * 10**9),
            new Planet('Mars', 0),
            new Planet('Jupiter', 0),
            new Planet('Saturn', 0),
            new Planet('Uranus', 0),
            new Planet('Neptune', 0),
        ];
    } 
}
```

Once again if you don't have PHP 7.4 you will need to remove the `PDO` property type on the `$connection` property.

Now write a script `storePlanets.php` to use this class:

```php
<?php declare(strict_types=1);

namespace AModeratelyShortPhpTutorial;

require_once __DIR__ . '/vendor/autoload.php';

use PDO;

$planetStore = new PlanetStore(
    new PDO("sqlite:". __DIR__ . '/database.sqlite')
);

$planetStore->storePlanets();
```

Run `php storePlanets.php`. This should add the eight planets to the database. It shouldn't produce any visible output.

The most important thing to notice about our code so far is that we didn't concatenate any strings to create queries to
send to the database. Instead we prepared a query, using question marks as placeholders for our data, and then supplied
the values of those parameters separately each time we executed the query.

This practice makes our database use much less error prone and more secure. The database engine knows what exactly
what's code that it should interpret and what's data that it should simply store.

Now let's write the code to show a planet. First let's add a function to the PlanetStore class to pull a Planet out of
the database:

```php
    public function getPlanet(string $planetName): ?Planet
    {
        $statement = $this->connection->prepare(
            'SELECT name, population_size FROM planets where name = :name;'
        );
        $statement->bindValue(':name', $planetName);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (! $row) {
            return null;
        }

        return new Planet($row['name'], (float) $row['population_size']);
    }
```

Notice the return type: `?Planet` means that the function may either return an instance of Planet, or the value `null`.
We can add `?` to the beginning of any type name to make it *nullable*.

We use `(float)` to **cast** or convert the population size data from a string, as it comes back from the sqlite DB, to 
a floating point number. 

In this case we have used a named parameter in the database query, instead of a question mark.

Finally we need to make a PHP script to go between this function and the browser. Call it `viewPlanet.php`:

```php
<?php declare(strict_types=1);

namespace AModeratelyShortPhpTutorial;

require_once __DIR__ . '/vendor/autoload.php';

use PDO;

$planetStore = new PlanetStore(
    new PDO("sqlite:". __DIR__ . '/database.sqlite')
);

$planet = $planetStore->getPlanet((string)$_GET['name']);

header('Content-Type: text/plain');
if ($planet === null) {
    http_response_code(404);
    echo ('Planet not found');
    exit();
}

echo "**********   {$planet->getName()}   **********\n\n";
echo "Population: {$planet->getPopulationSize()}\n";
```

Notice the `$_GET` array - PHP automatically fills this so-called **superglobal** array with any query parameters sent by
the browser. It is available to us anywhere in our program, but it's best to limit where we use it - code that directly
pulls data from superglobals can be very hard to test and re-use and understand.

Run the PHP server:
```shell script
php -S localhost:8080
```

Open [http://localhost:8080/viewPlanet.php?name=Earth](http://localhost:8080/viewPlanet.php?name=Earth) in your browser.

## Other Database Engines.

PDO has [drivers](https://www.php.net/manual/en/pdo.drivers.php) for eleven other database engines that you can use
use instead of SQLite. Connecting, sending queries, and receiving rows should work in the same way, but of course the
details of connection strings and SQL code will vary from DB to DB.

