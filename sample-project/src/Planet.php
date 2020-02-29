<?php declare(strict_types=1);

namespace PhpAsASecondLanguage;

final class Planet
{
    private string $name;

    private float $populationSize;

    public function __construct(string $name, float $populationSize)
    {
        $this->name = $name;
        $this->populationSize = $populationSize;
    }

   public function getName(): string
   {
       return $this->name;
   }

   public function getPopulationSize(): float
   {
       return $this->populationSize;
   }

   public static function earth(): self
   {
       return new self('Earth', 7.7 * 10**9);
   }
}
