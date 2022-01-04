<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\State\State;

class Chain implements MutatorInterface
{
    public Id $id = Id::Chain;

    public function __construct(
        public readonly Cid $card,
    )
    {
    }

    public function mutate(State $state): void
    {
        $state->me->chains->add($this->card);
    }
}
