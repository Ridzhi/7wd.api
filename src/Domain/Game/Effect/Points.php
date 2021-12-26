<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\ScorableInterface;
use App\Domain\Game\State\State;

class Points extends Base implements ScorableInterface
{
    public function __construct(
        public readonly int $count,
    )
    {
        parent::__construct(Id::Points);
    }

    public function getPoints(State $state): int
    {
        return $this->count;
    }
}
