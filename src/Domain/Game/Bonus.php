<?php

namespace App\Domain\Game;

enum Bonus: int
{
    case Resources = 1;
    case RawMaterials = 2;
    case ManufacturedGoods = 3;
    case Military = 4;
    case Commercial = 5;
    case Civilian = 6;
    case Science = 7;
    case Wonder = 8;
    case Coin = 9;
}
