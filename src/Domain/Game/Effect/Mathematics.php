<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\ScorableInterface;
use App\Domain\Game\State\State;

class Mathematics implements ScorableInterface
{
    public Id $id = Id::Mathematics;

    public function getPoints(State $state): int
    {
        return $state->me->tokens->count() * 3;
    }
}
