<?php

namespace App\Domain\Game\Card;

enum Group: int
{
    case Civilian = 1;
    case Commercial = 2;
    case Guild = 3;
    case ManufacturedGoods = 4;
    case Military = 5;
    case RawMaterials = 6;
    case Science = 7;
}
