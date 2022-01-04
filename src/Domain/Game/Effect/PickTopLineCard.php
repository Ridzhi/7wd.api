<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class PickTopLineCard implements MutatorInterface
{
    public Id $id = Id::PickTopLineCard;

    public function mutate(State $state): void
    {
        // @TODO: dialog
    }
}
