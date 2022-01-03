<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Discount\Context;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\Rule;
use App\Domain\Game\State\State;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;
use App\Domain\Game\Wonder\Repository as WonderRepository;

class ConstructWonder implements MutatorInterface
{
    public Id $id = Id::ConstructWonder;

    public function __construct(
        public readonly Wid $wonder,
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

        if (!$state->me->wonders->has($this->wonder)) {
            throw new InvalidError();
        }

        if ($state->me->wonders->isConstructed($this->wonder)) {
            throw new InvalidError();
        }

        $wonder = WonderRepository::get($this->wonder);

        $state->me->pay(Context::Wonder, $wonder->cost, $state->enemy);
        $state->deck->remove($this->card);
        $state->me->wonders->construct($this->wonder, $this->card);

        $totalConstructed = $state->me->wonders->countConstructed() + $state->enemy->wonders->countConstructed();

        if ($totalConstructed === Rule::WONDERS_CONSTRUCT_LIMIT) {
            $state->me->wonders->removeNotConstructed();
            $state->enemy->wonders->removeNotConstructed();
        }

        $wonder->mutate($state);

        if ($state->me->tokens->has(Tid::Theology)) {
            $state->playAgain = true;
        }

        $state->after();
    }
}
