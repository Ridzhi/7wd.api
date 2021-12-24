<?php

namespace App\Domain\Game\Move;

enum Id: int
{
    case BurnCard = 1;
    case ConstructCard = 2;
}
