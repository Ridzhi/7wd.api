<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class AdjustDiscardReward implements MutatorInterface
{
    public Id $id = Id::AdjustDiscardReward;

    public function mutate(State $state): void
    {
        $state->me->bank->discardReward += 1;
    }
}
