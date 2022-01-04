<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class PickReturnedCards implements MutatorInterface
{
    public Id $id = Id::PickReturnedCards;

    public function mutate(State $state): void
    {
        // @TODO: dialog
    }
}
