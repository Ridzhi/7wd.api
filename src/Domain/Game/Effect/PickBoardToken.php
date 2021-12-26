<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;

class PickBoardToken extends Base implements MutatorInterface
{
    public function __construct()
    {
        parent::__construct(Id::PickBoardToken);
    }

    public function mutate(State $state): void
    {
        // TODO: Implement mutate() method.
    }
}
