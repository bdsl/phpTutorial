# Templating

Our planet viewer works, but it isn't pretty. Let's use some HTML to make it look a little better.

It has been a common practice to use PHP as a templating language, and even mix PHP and HTML code together in the same
file. While PHP can still be used as a templating language, it isn't a good one, so we won't do that.

Instead, we will use PHP to prepare whatever data we want to show, and then pass that to a template written in a
different language. 

There are dozens of template engines available as libraries to use in PHP programs, and another good option
is to make a single page application, with all templating done in the browser, and data sent from the server as JSON.

## Twig

For this tutorial we will write a template in the **Twig** language, which works with PHP.

First install Twig in your project by running:

```shell script
composer require "twig/twig:^3.0"
```

Now let's make our template. Start by writing a page in HTML. For now we'll hard code everything. Make a 
'`templates`' directory, and save the following as '`templates/planet.html.twig`':

```html
<!doctype html>
<html>
    <head>
        <title>Some Planet</title>
    </head>
    <body>
        <h1>Some Planet</h1>
        <p>Population: 34601</p>
    </body>
</html>
```

Edit our `viewPlanet.php` file to make it use this template:

```php
<?php declare(strict_types=1);

namespace AModeratelyShortPhpTutorial;

require_once __DIR__ . '/vendor/autoload.php';

use PDO;
use Twig\Loader\FilesystemLoader;

$planetStore = new PlanetStore(
    new PDO("sqlite:". __DIR__ . '/database.sqlite')
);

$templateLoader = new FilesystemLoader(__DIR__ . '/templates/');
$twig = new \Twig\Environment($templateLoader);

$planet = $planetStore->getPlanet($_GET['name']);

header('Content-Type: text/html');
if ($planet === null) {
    http_response_code(404);
    echo ('Planet not found');
    exit();
}

$template = $twig->load('planet.html.twig');

echo $template->render();
```

If you run the PHP server again and view your site you should see the content of the template. Of course at this point
all we're doing is serving static HTML with extra steps.

Behind the scenes the Twig engine compiles the template to a PHP class. We don't need to read the class, but this is
useful because it means we can pass PHP objects to it and use their properties and functions. Let's pass our planet
object to the template. Change the last line of '`viewPlanet.php`' to:

```php
echo $template->render(['planet' => $planet]);
```

Finally we need to edit '`planet.html.twig'`. Since we won't always be reading the template at the same time as the PHP file 
that uses it, and neither will any tools and IDEs we might be using, we should add a comment to make it clear that we
expect to have a `planet` variable, and it will be of type `Planet`. Add the following to the top of the file:

```twig
{#  @var planet AModeratelyShortPhpTutorial\Planet #}
```

In Twig we use double curly brackets to output dynamic data: Replace `Some Planet` with 
`{{planet.name}}`, and replace `34601` with `{{planet.populationSize}}`. Twig knows that we mean `getName` and 
`getPopulationSize`, so we don't have to write those function names out in full.

If you reload the page you should now see the planet details in their proper places.

Twig is a full featured special purpose programming language, with features like loops, conditionals, filters,
inheritance, etc, but this is a PHP tutorial, not a Twig tutorial.