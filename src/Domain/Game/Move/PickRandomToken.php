<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;
use App\Domain\Game\Token\Id as Tid;

class PickRandomToken implements MutatorInterface
{
    public Id $id = Id::PickRandomToken;

    public function __construct(
        public readonly Tid $token,
    )
    {
    }

    public function mutate(State $state): void
    {
        // TODO: Implement mutate() method.
    }
}
