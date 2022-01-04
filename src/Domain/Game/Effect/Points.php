<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\ScorableInterface;
use App\Domain\Game\State\State;

class Points implements ScorableInterface
{
    public Id $id = Id::Points;

    public function __construct(
        public readonly int $count,
    )
    {
    }

    public function getPoints(State $state): int
    {
        return $this->count;
    }
}
