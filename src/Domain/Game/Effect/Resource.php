<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\State\State;

class Resource extends Base implements MutatorInterface
{
    public function __construct(
        public readonly Rid $resource,
        public readonly int $count,
    )
    {
        parent::__construct(Id::Resource);
    }

    public function mutate(State $state): void
    {
//        $state->me->resources->add($this->resource, $this->count);
//
//        if (!$state->enemy->resources->hasFixedCost($this->resource)) {
//            $newCost = $state->enemy->resources->getCost($this->resource) + $this->count;
//            $state->enemy->resources->setCost($this->resource, $newCost);
//        }
    }
}
