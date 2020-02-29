<?php declare(strict_types=1);

namespace AModeratelyShortPhpTutorial;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/PlanetStore.php';
require_once __DIR__ . '/Planet.php';

use PDO;

$planetStore = new PlanetStore(
    new PDO("sqlite:". __DIR__ . '/database.sqlite')
);


$planet = $planetStore->getPlanet($_GET['name']);

header('Content-Type: text/plain');
if ($planet === null) {
    http_response_code(404);
    echo ('Planet not found');
    exit();
}

echo "**********   {$planet->getName()}   **********\n\n";
echo "Population: {$planet->getPopulationSize()}\n";
