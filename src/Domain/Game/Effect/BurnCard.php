<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Card\Type;
//use App\Domain\Game\Dialog;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class BurnCard implements MutatorInterface
{
    public Id $id = Id::BurnCard;

    public function __construct(
        public readonly Type $group,
    )
    {
    }

    public function mutate(State $state): void
    {
        // @TODO
//        $state->dialogs->add(new Dialog(
//            phase: Phase::BurnCard,
//            turn: $state->me->name,
//            action: function (State $state): void {
//                $state->dialogCards = $state->enemy->cards->get($this->type);
//            }
//        ));
    }
}
