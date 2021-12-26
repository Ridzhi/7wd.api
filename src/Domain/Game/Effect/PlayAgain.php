<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class PlayAgain extends Base implements MutatorInterface
{
    public function __construct()
    {
        parent::__construct(Id::PlayAgain);
    }

    public function mutate(State $state): void
    {
        // TODO: Implement mutate() method.
    }
}
