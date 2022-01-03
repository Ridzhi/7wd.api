<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\State\State;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Token\Repository as TokenRepository;

class PickRandomToken implements MutatorInterface
{
    public Id $id = Id::PickRandomToken;

    public function __construct(
        public readonly Tid $token,
    )
    {
    }

    public function mutate(State $state): void
    {
        if ($state->phase !== Phase::PickRandomToken) {
            throw new InvalidError();
        }

        if (!in_array($this->token, $state->dialogItems->tokens)) {
            throw new InvalidError();
        }

        $state->me->tokens->add($this->token);
        TokenRepository::get($this->token)->mutate($state);

        $state->after();
    }
}
