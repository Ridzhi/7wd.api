<?php

namespace App\Domain\Game\Card;

use App\Domain\Game\BurnInterface;
use App\Domain\Game\EffectsSupport;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Effect\Base;
use App\Domain\Game\Age;
use App\Domain\Game\Cost;
use App\Domain\Game\ScorableInterface;

class Card implements MutatorInterface, ScorableInterface, BurnInterface
{
    use EffectsSupport;

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
        array  $effects = [],
    )
    {
        $this->effects = $effects;
    }
}
