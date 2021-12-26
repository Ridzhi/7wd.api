<?php

namespace App\Domain\Game;

use App\Domain\Game\State\State;

interface ScorableInterface
{
    public function getPoints(State $state): int;
}
