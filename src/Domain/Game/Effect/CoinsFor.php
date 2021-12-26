<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Bonus;
use App\Domain\Game\State\State;

class CoinsFor extends Base implements MutatorInterface
{
    public function __construct(
        public readonly Bonus $bonus,
        public readonly int $count,
    )
    {
        parent::__construct(Id::CoinsFor);
    }

    public function mutate(State $state): void
    {
//        $state->me->treasure->add($state->me->getBonusRate($this->bonus) * $this->count);
    }
}
