<?php

namespace App\Domain;

class RoomOptions
{
    public function __construct(
        private ?bool   $fast = null,
        private ?int    $minRating = null,
        // use for private game
        private ?string $enemy = null,
    )
    {
    }

    public function getFast(): ?bool
    {
        return $this->fast;
    }

    public function getMinRating(): ?int
    {
        return $this->minRating;
    }

    public function getEnemy(): ?string
    {
        return $this->enemy;
    }
}
