<?php

namespace App\Domain\Game\Dialog;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class BurnCard implements MutatorInterface
{
    public function __construct(
        private string $name,
    )
    {
    }

    public function mutate(State $state): void
    {
        $state->phase = Phase::BurnCard;
        $state->setTurn($this->name);

    }
}
