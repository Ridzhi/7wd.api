<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Card\Repository as CardRepository;
use App\Domain\Game\Discount\Context;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;
use App\Domain\Game\Token\Id as Tid;

class ConstructCard implements MutatorInterface
{
    public Id $id = Id::ConstructCard;

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

        $card = CardRepository::get($this->card);

        if ($state->me->chains->has($this->card)) {
            if ($state->me->tokens->has(Tid::Urbanism)) {
                $state->me->treasure->change(4);
            }
        } else {
            $state->me->pay(
                Context::byCard($this->card),
                $card->cost,
                $state->enemy,
            );
        }

        $state->me->cards->add($this->card);
        $state->deck->remove($this->card);
        $card->mutate($state);

        $state->after();
    }
}
