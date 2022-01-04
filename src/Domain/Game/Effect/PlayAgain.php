<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class PlayAgain implements MutatorInterface
{
    public Id $id = Id::PlayAgain;

    public function mutate(State $state): void
    {
        $state->playAgain = true;
    }
}
