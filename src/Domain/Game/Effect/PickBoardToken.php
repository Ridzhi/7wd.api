<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class PickBoardToken implements MutatorInterface
{
    public Id $id = Id::PickBoardToken;

    public function mutate(State $state): void
    {
        // @TODO: dialog
    }
}
