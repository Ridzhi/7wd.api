<?php

namespace App\Domain\Game\Resource;

use SplObjectStorage;

class Storage extends SplObjectStorage
{
    public function __construct(
        int $clay = 0,
        int $wood = 0,
        int $stone = 0,
        int $glass = 0,
        int $papyrus = 0,
    )
    {
        $this[Id::Clay] = $clay;
        $this[Id::Wood] = $wood;
        $this[Id::Stone] = $stone;
        $this[Id::Glass] = $glass;
        $this[Id::Papyrus] = $papyrus;
    }
}
