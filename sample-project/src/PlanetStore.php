<?php declare(strict_types=1);

namespace PhpAsASecondLanguage;

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

        return new Planet($row['name'], (float)$row['population_size']);
    }
}
