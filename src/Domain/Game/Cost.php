<?php

namespace App\Domain\Game;

use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Resource\Storage;

class Cost
{
    public int $coins;

    /**
     * @var Storage | array<Rid,int>
     * @noinspection PhpDocFieldTypeMismatchInspection
     */
    public Storage $resources;

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
