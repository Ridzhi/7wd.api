<?php

namespace App\Domain\Game;

use App\Domain\Game\State\State;

class Dialog implements MutatorInterface
{
    public function __construct(
        private Phase    $phase,
        private string   $turn,
        private \Closure $mutation,
    )
    {
    }

    public function mutate(State $state): void
    {
        $state->phase = $this->phase;
        $state->setTurn($this->turn);

        call_user_func($this->mutation, $state);
    }
}
