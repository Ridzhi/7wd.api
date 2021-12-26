<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\State\State;

class Chain extends Base implements MutatorInterface
{
    public function __construct(
        public readonly Cid $card,
    )
    {
        parent::__construct(Id::Chain);
    }

    public function mutate(State $state): void
    {
//        $state->me->chains->add($this->cid);
    }
}
