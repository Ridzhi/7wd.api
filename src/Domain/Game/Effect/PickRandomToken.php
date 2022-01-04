<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class PickRandomToken implements MutatorInterface
{
    public Id $id = Id::PickRandomToken;

    public function mutate(State $state): void
    {
        // @TODO dialog
    }
}
