<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Dialog;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class PickTopLineCard implements MutatorInterface
{
    public Id $id = Id::PickTopLineCard;

    public function mutate(State $state): void
    {
        $items = $state->deck->getTopLineCards();

        if (!empty($items)) {
            $state->dialogs[] = new Dialog(
                phase: Phase::PickTopLineCard,
                turn: $state->me->name,
                mutation: function (State $state) use ($items): void {
                    $state->dialogItems->cards = $items;
                }
            );
        }
    }
}
