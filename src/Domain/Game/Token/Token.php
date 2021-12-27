<?php

namespace App\Domain\Game\Token;

use App\Domain\Game\Effect\Base;
use App\Domain\Game\EffectsSupport;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\ScorableInterface;

class Token implements MutatorInterface, ScorableInterface
{
    use EffectsSupport;

    /**
     * @param Id $id
     * @param Base[] $effects
     */
    public function __construct(
        public readonly Id $id,
        array  $effects,
    )
    {
        $this->effects = $effects;
    }
}
