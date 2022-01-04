<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Discount\Discount;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class Discounter implements MutatorInterface
{
    public Id $id = Id::Discounter;

    public function __construct(
        public readonly Discount $discount,
    )
    {
    }

    public function mutate(State $state): void
    {
        $state->me->discounter->add($this->discount);
    }
}
