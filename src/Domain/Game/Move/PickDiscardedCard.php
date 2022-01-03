<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Card\Repository as CardRepository;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class PickDiscardedCard implements MutatorInterface
{
    public Id $id = Id::PickDiscardedCard;

    public function __construct(
        public readonly Cid $card,
    )
    {
    }

    public function mutate(State $state): void
    {
        if ($state->phase !== Phase::PickDiscardedCard) {
            throw new InvalidError();
        }

        if (!in_array($this->card, $state->dialogItems->cards)) {
            throw new InvalidError();
        }

        $state->me->cards->add($this->card);
        $state->cardItems->removeFromDiscard($this->card);
        CardRepository::get($this->card)->mutate($state);

        $state->after();
    }
}
