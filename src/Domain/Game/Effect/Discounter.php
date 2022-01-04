<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Discount\Context;
use App\Domain\Game\Discount\Discount;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\State\State;
use Symfony\Component\Serializer\Annotation\Ignore;

class Discounter implements MutatorInterface
{
    public Id $id = Id::Discounter;

    /**
     * @var array<Rid>
     */
    public readonly array $resources;

    public function __construct(
        #[Ignore]
        public readonly Context $context,
        #[Ignore]
        public readonly int $count,
        Rid               ...$resources,
    )
    {
        $this->resources = $resources;
    }

    public function mutate(State $state): void
    {
        $state->me->discounter->add(
            new Discount(
                $this->context,
                $this->count,
                ...$this->resources
            ),
        );
    }
}
