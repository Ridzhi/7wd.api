<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Bonus;
use App\Domain\Game\ScorableInterface;
use App\Domain\Game\State\State;

class Guild implements MutatorInterface, ScorableInterface
{
    public Id $id = Id::Guild;

    public function __construct(
        public readonly Bonus $bonus,
        public readonly int $points,
        public readonly int $coins,
    )
    {
    }

    public function mutate(State $state): void
    {
        $state->me->treasure->add($this->getRate($state) * $this->coins);
    }

    public function getPoints(State $state): int
    {
        return $this->getRate($state) * $this->points;
    }

    private function getRate(State $state): int
    {
        return max(
            $state->me->getBonusRate($this->bonus),
            $state->enemy->getBonusRate($this->bonus)
        );
    }
}
