<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;
use App\Domain\Game\Symbol;

class Science extends Base implements MutatorInterface
{
    public function __construct(
        public readonly Symbol $symbol,
    )
    {
        parent::__construct(Id::Science);
    }

    public function mutate(State $state): void
    {
//        $state->me->symbols->add($this->symbol);
//
//        if ($tokenReward = $state->me->symbols->count($this->symbol) === Value::TOKEN_SYMBOLS_COUNT) {
//            $state->apply(new PickToken(new BoardTokens()));
//
//            return;
//        }
//
//        if ($supremacyReached = $state->me->symbols->count() === Value::SUPREMACY_TOKENS_COUNT) {
//            $state->victory = Victory::Science;
//        }
    }
}
