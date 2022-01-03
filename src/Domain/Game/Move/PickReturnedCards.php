<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Card\Repository as CardRepository;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class PickReturnedCards implements MutatorInterface
{
    public Id $id = Id::PickReturnedCards;

    public function __construct(
        public readonly Cid $pick,
        public readonly Cid $give,
    )
    {
    }

    public function mutate(State $state): void
    {
        if ($state->phase !== Phase::PickReturnedCards) {
            throw new InvalidError();
        }

        if (
            !in_array($this->pick, $state->dialogItems->cards)
            || !in_array($this->give, $state->dialogItems->cards)
        ) {
            throw new InvalidError();
        }

        // pick is for me
        $state->me->cards->add($this->pick);
        CardRepository::get($this->pick)->mutate($state);

        // switch to enemy to handle give
        $state->nextTurn();
        $state->me->cards->add($this->give);
        CardRepository::get($this->give)->mutate($state);

        // switch back
        $state->nextTurn();

        $state->after();
    }
}
