<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class Fine implements MutatorInterface
{
    public Id $id = Id::Fine;

    public function __construct(
        public readonly int $coins,
    )
    {
    }

    public function mutate(State $state): void
    {
        $state->enemy->treasure->add(-$this->coins);
    }
}
