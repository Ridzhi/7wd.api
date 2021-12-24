<?php

namespace App\Domain\Game;

use JsonSerializable;

enum Victory: int implements JsonSerializable
{
    case Civilian = 1;
    case Military = 2;
    case Science = 3;
    case Resign = 4;
    case Timeout = 5;

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): int
    {
        return $this->value;
    }
}
