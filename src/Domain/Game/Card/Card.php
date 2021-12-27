<?php

namespace App\Domain\Game\Card;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Effect\Base;
use App\Domain\Game\Age;
use App\Domain\Game\Cost;
use App\Domain\Game\ScorableInterface;
use App\Domain\Game\State\State;

class Card implements MutatorInterface, ScorableInterface
{
    /**
     * @param Id $id
     * @param Age $age
     * @param Type $type
     * @param Cost|null $cost
     * @param Base[] $effects
     */
    public function __construct(
        public readonly Id $id,
        public readonly Age $age,
        public readonly Type $type,
        public readonly ?Cost $cost = null,
        public readonly array $effects = [],
    )
    {
    }

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
}
