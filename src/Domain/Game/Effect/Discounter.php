<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Discount\Discount;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class Discounter extends Base implements MutatorInterface
{
    public function __construct(
        public readonly Discount $discount,
    )
    {
        parent::__construct(Id::Discounter);
    }

    public function mutate(State $state): void
    {
//        $state->me->discounter->add($this->discount);
    }
}
