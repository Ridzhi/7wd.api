<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class Coins implements MutatorInterface
{
    public Id $id = Id::Coins;

    public function __construct(
        public readonly int $count,
    )
    {
    }

    public function mutate(State $state): void
    {
        $state->me->treasure->add($this->count);
    }
}
