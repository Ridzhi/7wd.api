<?php

namespace App\Domain\Game\Card;

use JsonSerializable;

enum Type: int
{
    case RawMaterials = 1;
    case ManufacturedGoods = 2;
    case Military = 3;
    case Science = 4;
    case Civilian = 5;
    case Commercial = 6;
    case Guild = 7;
}
