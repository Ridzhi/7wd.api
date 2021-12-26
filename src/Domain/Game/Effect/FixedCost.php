<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\State\State;

class FixedCost extends Base implements MutatorInterface
{
    /**
     * @var Rid[]
     */
    public readonly array $resources;

    public function __construct(
        Rid ...$resource
    )
    {
        $this->resources = $resource;
        parent::__construct(Id::FixedCost);
    }

    public function mutate(State $state): void
    {
//        foreach ($this->resources as $resource) {
//            $state->me->resources->setCost($resource, Value::FIXED_RESOURCE_COST);
//        }
    }
}
