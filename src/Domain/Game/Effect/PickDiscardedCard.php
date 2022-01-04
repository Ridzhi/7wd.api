<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Dialog;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class PickDiscardedCard implements MutatorInterface
{
    public Id $id = Id::PickDiscardedCard;

    public function mutate(State $state): void
    {
        $items = $state->cardItems->discarded;

        if (!empty($items)) {
            $state->dialogs[] = new Dialog(
                phase: Phase::PickDiscardedCard,
                turn: $state->me->name,
                mutation: function (State $state) use ($items): void {
                    $state->dialogItems->cards = $items;
                }
            );
        }
    }
}
