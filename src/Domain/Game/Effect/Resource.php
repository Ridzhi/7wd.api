<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Rule;
use App\Domain\Game\State\State;

class Resource implements MutatorInterface
{
    public Id $id = Id::Resource;

    public function __construct(
        public readonly Rid $resource,
        public readonly int $count,
    )
    {
    }

    public function mutate(State $state): void
    {
        $state->me->resources[$this->resource] += $this->count;

        if (!$state->enemy->bank->hasFixedResourcePrice($this->resource)) {
            $newPrice = Rule::DEFAULT_RESOURCE_PRICE + $state->me->resources[$this->resource];
            $state->enemy->bank->resourcePrice[$this->resource] = $newPrice;
        }
    }
}
