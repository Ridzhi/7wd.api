<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class Fine extends Base implements MutatorInterface
{
    public function __construct(
        public readonly int $coins,
    )
    {
        parent::__construct(Id::Fine);
    }

    public function mutate(State $state): void
    {
//        $state->enemy->treasure->add(-$this->coins);
    }
}
