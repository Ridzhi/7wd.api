<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Card\Group;
use App\Domain\Game\Dialog;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class BurnCard implements MutatorInterface
{
    public Id $id = Id::BurnCard;

    public function __construct(
        public readonly Group $group,
    )
    {
    }

    public function mutate(State $state): void
    {
        $items = $state->enemy->cards->get($this->group);

        if (!empty($items)) {
            $state->dialogs[] = new Dialog(
                phase: Phase::BurnCard,
                turn: $state->me->name,
                mutation: function (State $state) use ($items): void {
                    $state->dialogItems->cards = $items;
                }
            );
        }
    }
}
