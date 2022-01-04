<?php

namespace App\Infra\Messenger;

use App\Domain\Game\State\State;

class UpdateGameMessage
{
    public function __construct(
        private int   $gid,
        private State $state,
    )
    {
    }

    public function getId(): int
    {
        return $this->gid;
    }

    public function getState(): State
    {
        return $this->state;
    }
}
