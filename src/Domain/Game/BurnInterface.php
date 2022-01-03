<?php

namespace App\Domain\Game;

use App\Domain\Game\State\State;

interface BurnInterface
{
    public function burn(State $state): void;
}
