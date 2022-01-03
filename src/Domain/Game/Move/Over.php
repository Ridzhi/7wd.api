<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;
use App\Domain\Game\Victory;

class Over implements MutatorInterface
{
    public Id $id = Id::Over;

    public function __construct(
        public readonly string $loser,
        public readonly Victory $victory,
    )
    {
    }

    public function mutate(State $state): void
    {
        $winner = $state->me->name === $this->loser
            ? $state->enemy->name
            : $state->me->name;

        $state->over($this->victory, $winner);
    }
}
