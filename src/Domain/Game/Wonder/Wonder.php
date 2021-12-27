<?php

namespace App\Domain\Game\Wonder;

use App\Domain\Game\Effect\Base;
use App\Domain\Game\Cost;
use App\Domain\Game\EffectsSupport;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\ScorableInterface;

class Wonder implements MutatorInterface, ScorableInterface
{
    use EffectsSupport;

    /**
     * @param Id $id
     * @param Cost $cost
     * @param Base[] $effects
     */
    public function __construct(
        public readonly Id $id,
        public readonly Cost $cost,
        array  $effects,
    )
    {
        $this->effects = $effects;
    }
}
