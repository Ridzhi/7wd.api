<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;
use Symfony\Component\Serializer\Annotation\Ignore;

class Military extends Base implements MutatorInterface
{
    public function __construct(
        public readonly int  $power,
        #[Ignore]
        public readonly bool $strategyAllowed = true,
    )
    {
        parent::__construct(Id::Military);
    }

    public function mutate(State $state): void
    {
//        $power = $this->power;
//
//        if ($this->strategyAllowed && $state->me->tokens->has(Tid::Strategy)) {
//            $power++;
//        }
//
//        [$fine, $supremacy] = $state->board->moveConflictPawn($state->me->name, $power);
//
//        if ($fine > 0) {
//            $state->enemy->treasure->add(-$fine);
//        }
//
//        if ($supremacy) {
//            $state->victory = Victory::Military;
//        }
    }
}
