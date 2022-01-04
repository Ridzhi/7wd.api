<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Dialog;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class PickRandomToken implements MutatorInterface
{
    public Id $id = Id::PickRandomToken;

    public function mutate(State $state): void
    {
        // can't be empty, just same as others
        $items = $state->randomItems->tokens;

        if (!empty($items)) {
            $state->dialogs[] = new Dialog(
                phase: Phase::PickRandomToken,
                turn: $state->me->name,
                mutation: function (State $state) use ($items): void {
                    $state->dialogItems->tokens = $items;
                }
            );
        }
    }
}
