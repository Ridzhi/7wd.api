<?php

namespace App\Domain\Game;

enum Age: int
{
    case I = 1;
    case II = 2;
    case III = 3;

    public function next(): Age
    {
        return Age::from($this->value + 1);
    }
}
