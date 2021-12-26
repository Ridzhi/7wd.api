<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Card\Type;
//use App\Domain\Game\Dialog;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class BurnCard extends Base implements MutatorInterface
{
    public function __construct(
        public readonly Type $type,
    )
    {
        parent::__construct(Id::BurnCard);
    }

    public function mutate(State $state): void
    {
//        $state->dialogs->add(new Dialog(
//            phase: Phase::BurnCard,
//            turn: $state->me->name,
//            action: function (State $state): void {
//                $state->dialogCards = $state->enemy->cards->get($this->type);
//            }
//        ));
    }
}
