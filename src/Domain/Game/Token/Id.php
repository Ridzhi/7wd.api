<?php

namespace App\Domain\Game\Token;

enum Id: int
{
    case Agriculture = 1;
    case Architecture = 2;
    case Economy = 3;
    case Law = 4;
    case Masonry = 5;
    case Mathematics = 6;
    case Philosophy = 7;
    case Strategy = 8;
    case Theology = 9;
    case Urbanism = 10;
}
