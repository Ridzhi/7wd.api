<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\Dialog;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\Provider\Token\TokensProviderInterface;
use App\Domain\Game\State\State;

class PickToken extends Base implements MutatorInterface
{
    public function __construct(
        private TokensProviderInterface $tokenProvider,
    )
    {
        parent::__construct(Id::PickToken);
    }

    /**
     * @inheritDoc
     */
    public function mutate(State $state): void
    {
        $state->dialogs->add(new Dialog(
            phase: Phase::PickToken,
            turn: $state->me->name,
            action: function (State $state): void {
                $state->dialogTokens = $this->tokenProvider->getTokens($state);
            }
        ));
    }
}
