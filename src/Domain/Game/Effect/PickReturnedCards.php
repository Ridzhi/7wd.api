<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class PickReturnedCards extends Base implements MutatorInterface
{
    public function __construct()
    {
        parent::__construct(Id::PickReturnedCards);
    }

    public function mutate(State $state): void
    {
        // TODO: Implement mutate() method.
    }
}
