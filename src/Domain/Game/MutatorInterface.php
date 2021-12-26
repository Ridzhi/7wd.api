<?php

namespace App\Domain\Game;

use App\Domain\Game\State\State;

interface MutatorInterface
{
    public function mutate(State $state): void;
}
