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
        if ($clay) {
            $this[Id::Clay] = $clay;
        }

        if ($wood) {
            $this[Id::Wood] = $wood;
        }

        if ($stone) {
            $this[Id::Stone] = $stone;
        }

        if ($glass) {
            $this[Id::Glass] = $glass;
        }

        if ($papyrus) {
            $this[Id::Papyrus] = $papyrus;
        }
    }
}
