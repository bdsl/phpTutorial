<?php declare(strict_types=1);

namespace PhpAsASecondLanguage;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/PlanetStore.php';
require_once __DIR__ . '/Planet.php';

use PDO;

$planetStore = new PlanetStore(
    new PDO("sqlite:". __DIR__ . '/database.sqlite')
);

$planetStore->storePlanets();
