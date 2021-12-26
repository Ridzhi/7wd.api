<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class Coins extends Base implements MutatorInterface
{
    public function __construct(
        public readonly int $count,
    )
    {
        parent::__construct(Id::Coins);
    }

    public function mutate(State $state): void
    {
//        $state->me->treasure->add($this->count);
    }
}
