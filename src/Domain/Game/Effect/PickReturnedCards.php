<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Dialog;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class PickReturnedCards implements MutatorInterface
{
    public Id $id = Id::PickReturnedCards;

    public function mutate(State $state): void
    {
        // can't be empty, just same as others
        $items = $state->deck->getReturnedCards();

        if (!empty($items)) {
            $state->dialogs[] = new Dialog(
                phase: Phase::PickReturnedCards,
                turn: $state->me->name,
                mutation: function (State $state) use ($items): void {
                    $state->dialogItems->cards = $items;
                }
            );
        }
    }
}
