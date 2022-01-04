<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;
use App\Domain\Game\Symbol;
use App\Domain\Game\SymbolStatus;
use App\Domain\Game\Victory;

class Science implements MutatorInterface
{
    public Id $id = Id::Science;

    public function __construct(
        public readonly Symbol $symbol,
    )
    {
    }

    public function mutate(State $state): void
    {
        switch ($state->me->symbols->add($this->symbol)) {
            case SymbolStatus::Token:
                (new PickBoardToken())->mutate($state);
                break;
            case SymbolStatus::Supremacy:
                $state->over(Victory::Science, $state->me->name);
                break;
            case SymbolStatus::Null:
                //nothing
        }
    }
}
