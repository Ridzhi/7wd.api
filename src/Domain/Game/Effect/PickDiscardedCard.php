<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class PickDiscardedCard implements MutatorInterface
{
    public Id $id = Id::PickDiscardedCard;

    public function mutate(State $state): void
    {
        // @TODO: dialog
    }
}
