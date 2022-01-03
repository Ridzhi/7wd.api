<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class SelectWhoStartsTheNextAge implements MutatorInterface
{
    public Id $id = Id::SelectWhoStartsTheNextAge;

    public function __construct(
        public readonly string $player,
    )
    {
    }

    public function mutate(State $state): void
    {
        if ($state->phase !== Phase::SelectWhoStartsTheNextAge) {
            throw new InvalidError();
        }

        $state->setTurn($this->player);

        $state->phase = Phase::Turn;
    }
}
