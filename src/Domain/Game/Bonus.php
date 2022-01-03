<?php

namespace App\Domain\Game;

enum Bonus: int
{
    case Civilian = 1;
    case Coin = 2;
    case Commercial = 3;
    case ManufacturedGoods = 4;
    case Military = 5;
    case RawMaterials = 6;
    case Resources = 7;
    case Science = 8;
    case Wonder = 9;
}
