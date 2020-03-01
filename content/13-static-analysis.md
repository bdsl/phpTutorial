{% block title%}Static Analysis{% endblock %}

{% block body%}


I recommend using at least one static analysis tool on any PHP project. While languages like TypeScript and Java have
explicit compilation phases that can quickly catch lots of errors, PHP doesn't. Most of the type checks in PHP happen only
as each line of code is executed.

Unit tests help, but 100% test coverage is unlikely, and even then we can only ever test with a few example inputs. For
more confidence we need static analysis as well, especially if we want to be able to easily refactor our code and upgrade
the libraries we're using. 

Static Analysers for PHP include [Psalm](https://psalm.dev/), [PHPStan](https://github.com/phpstan/phpstan) and
[Phan](https://github.com/phan/phan). In this tutorial we will use Psalm.

## Running Psalm

Install Psalm with Composer:

```shell script
composer require --dev vimeo/psalm
```

Create a Psalm Config file:

```shell script
./vendor/bin/psalm --init
```

Finally, run Psalm to check your code:

```shell script
./vendor/bin/psalm
```

You should see something like:

```text
Calculating best config level based on project files
Calculating best config level based on project files
Scanning files...
Analyzing files...

░E

Detected level 7 as a suitable initial default
Config file created successfully. Please re-run psalm.
```

Re-run Psalm as instructed. If your code is the same as mine, you should see "No errors found!", and 
"1 other issues found. You can display them with --show-info=true".

That's OK, but where's the fun in a static analysis tool that doesn't complain about anything? Let's change the Psalm
settings to make it a lot stricter. Open '`psalm.xml`' and change `errorLevel="7"` to `errorLevel="1"`.

Re-run Psalm. Now you should see an error:

<code>
<span style="color: red;">ERROR</span>: InvalidArgument - src/PlanetStore.php:52:27 - Argument 1 of AModeratelyShortPhpTutorial\Planet::__construct expects string, scalar provided<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return new Planet(<span style="color: white; background: red;">$row['name']</span>, (float)$row['population_size']);
</code>

Psalm has looked at our code, and the code of the libraries and modules we're using, and found a mismatch. The planet
class constructor needs a string, but we've passed it something from the array returned by the 
[PDOStatement::fetch](https://www.php.net/manual/en/pdostatement.fetch.php).

Psalm knows that when we call `fetch` with `\PDO::FETCH_ASSOC` we will either get `false` or an array of scalar
values (i.e. not objects). It can see that the value isn't false at line 52, because when it is false the function
returns early, skipping that line.

In this case we know our database a bit better than Psalm does, and we need to add a comment to tell Psalm that fetch
will return either false or an array of strings. Edit '`PlanetStore.php`' and add docblock for the `$row` variable:

```php
        /** @var array<string, string>|false $row */
        $row = $statement->fetch(PDO::FETCH_ASSOC);
```

This docbloc means that the `$row` variable's type is the union of false and string-indexed, string-valued array. In
other words it either holds the value `false`, or it holds an array, in which any keys are strings and any values are
also strings. `|` combines types to make a **union type**. The `< >` brackets are used to provide arguments for a 
**generic type**. `false` is an example of a **literal type**.

Psalm's type system extends the PHP type system, and is a lot more expressive. PHP itself does not have union, generic,
or literal types, although unions are coming in PHP 8. We can use types that PHP doesn't support by writing them in
docblocks, with tags such as 
[@var](https://manual.phpdoc.org/HTMLSmartyConverter/HandS/phpDocumentor/tutorial_tags.var.pkg.html),
[@param](https://manual.phpdoc.org/HTMLSmartyConverter/HandS/phpDocumentor/tutorial_tags.param.pkg.html), and
[@return](https://manual.phpdoc.org/HTMLSmartyConverter/HandS/phpDocumentor/tutorial_tags.return.pkg.html),
and making sure we run our static analysis tool every time
we edit our source code.

Let's add a deliberate mistake to our code to see a bit more of what Psalm can help us with. Let's suppose we forgot
that the database might not have the planet we're looking for. Comment out the check for that in '`planetStore.php`':

```php
//        if (! $row) {
//            return null;
//        }
```

Re-run Psalm. It now reports two **PossiblyInvalidArrayAccess** errors, telling us that we 
'`Cannot access array value on non-array variable $row of type false`'. This is a reminder that we should have made sure
that `$row` is not false before trying to use it as an array. If we leave it like this our server will produce an HTTP
500 internal server error instead of displaying the 404 page when someone asks to see the planet Pluto. Put the check
back to make Psalm happy again.
{% endblock %}