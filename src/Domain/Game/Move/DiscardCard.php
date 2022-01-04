<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;

class DiscardCard implements MutatorInterface
{
    public Id $id = Id::DiscardCard;

    public function __construct(
        public readonly Cid $card,
    )
    {
    }

    public function mutate(State $state): void
    {
        if ($state->phase !== Phase::Turn) {
            throw new InvalidError();
        }

        if (!$state->cardItems->isPlayable($this->card)) {
            throw new InvalidError();
        }

        $state->cardItems->addToDiscard($this->card);
        $state->deck->remove($this->card);
        $state->me->treasure->add($state->me->bank->discardReward);

        $state->after();
    }
}
