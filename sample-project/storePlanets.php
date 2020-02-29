<?php declare(strict_types=1);

namespace AModeratelyShortPhpTutorial;

require_once __DIR__ . '/vendor/autoload.php';

use PDO;

$planetStore = new PlanetStore(
    new PDO("sqlite:". __DIR__ . '/database.sqlite')
);

$planetStore->storePlanets();
