<?php

namespace App\Domain\Game\Discount;

enum Context: int
{
    case Global = 1;
    case Civilian = 2;
    case Wonder = 3;
}
