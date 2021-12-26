<?php

namespace App\Domain\Game;

use App\Domain\Game\Resource\Storage;

class Cost
{
    public readonly int $coins;
    public readonly Storage $resources;

    public function __construct(
        int $coins = 0,
        int $clay = 0,
        int $wood = 0,
        int $stone = 0,
        int $glass = 0,
        int $papyrus = 0,
    )
    {
        $this->coins = $coins;
        $this->resources = new Storage(
            clay: $clay,
            wood: $wood,
            stone: $stone,
            glass: $glass,
            papyrus: $papyrus,
        );
    }
}
