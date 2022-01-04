<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Rule;
use App\Domain\Game\State\State;

class FixedCost implements MutatorInterface
{
    public Id $id = Id::FixedCost;

    /**
     * @var array<Rid>
     */
    public readonly array $resources;

    public function __construct(
        Rid ...$resource
    )
    {
        $this->resources = $resource;
    }

    public function mutate(State $state): void
    {
        foreach ($this->resources as $resource) {
            $state->me->bank->resourcePrice[$resource] = Rule::FIXED_RESOURCE_PRICE;
        }
    }
}
