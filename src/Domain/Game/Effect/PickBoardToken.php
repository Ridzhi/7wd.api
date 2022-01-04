<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Dialog;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class PickBoardToken implements MutatorInterface
{
    public Id $id = Id::PickBoardToken;

    public function mutate(State $state): void
    {
        // can't be empty, just same as others
        $items = $state->tokens;

        if (!empty($items)) {
            $state->dialogs[] = new Dialog(
                phase: Phase::PickBoardToken,
                turn: $state->me->name,
                mutation: function (State $state) use ($items): void {
                    $state->dialogItems->tokens = $items;
                }
            );
        }
    }
}
