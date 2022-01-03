<?php

namespace App\Domain\Game;

use App\Domain\Game\State\State;

trait EffectsSupport
{
    public readonly array $effects;

    public function mutate(State $state): void
    {
        foreach ($this->effects as $effect) {
            if ($effect instanceof MutatorInterface) {
                $effect->mutate($state);
            }
        }
    }

    public function getPoints(State $state): int
    {
        $points = 0;

        foreach ($this->effects as $effect) {
            if ($effect instanceof ScorableInterface) {
                $points += $effect->getPoints($state);
            }
        }

        return $points;
    }

    public function burn(State $state): void
    {
        foreach ($this->effects as $effect) {
            if ($effect instanceof BurnInterface) {
                $effect->burn($state);
            }
        }
    }
}
