<?php declare(strict_types=1);

namespace PhpAsASecondLanguage;
use PDO;

file_put_contents( __DIR__ . '/database.sqlite', '');

$pdo = new PDO("sqlite:".__DIR__."/database.sqlite");

$pdo->query(<<<SQL
    CREATE TABLE planets (
        id INTEGER PRIMARY KEY,
        name text,
        population_size INTEGER
    );
SQL
);
