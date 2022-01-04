<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Victory;
use Symfony\Component\Serializer\Annotation\Ignore;

class Military implements MutatorInterface
{
    public Id $id = Id::Military;

    public function __construct(
        public readonly int $power,
        #[Ignore]
        public readonly bool $strategyAllowed = true,
    )
    {
    }

    public function mutate(State $state): void
    {
        $power = $this->power;

        if (
            $this->strategyAllowed
            && $state->me->tokens->has(Tid::Strategy)
        ) {
            $power++;
        }

        [
            'fine' => $fine,
            'supremacy' => $supremacy,
        ] = $state->me->track->moveConflictPawn($power, $state->enemy->track);

        if ($fine > 0) {
            $state->enemy->treasure->add(-$fine);
        }

        if ($supremacy) {
            $state->over(Victory::Military, $state->me->name);
        }
    }
}
