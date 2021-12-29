<?php

namespace App\Domain\Game;

enum SymbolStatus: int
{
    case Null = 0;
    case Token = 1;
    case Supremacy = 2;
}
