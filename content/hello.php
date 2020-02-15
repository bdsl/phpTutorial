<?php declare(strict_types=1);

$planets = ['Mercury', 'Venus', 'Earth', 'Mars', 'Jupiter', 'Saturn', 'Uranus', 'Neptune'];

natsort($planets);

foreach ($planets as $number => $planet) {
    echo "Hello, $planet, you are planet number $number.\n";
}

$dwarfPlanet = 'Pluto';
echo "Hello, $dwarfPlanet.\n";