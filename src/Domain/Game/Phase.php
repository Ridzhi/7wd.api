<?php

namespace App\Domain\Game;

enum Phase: int
{
    case Null = 0;
    case Turn = 1;
    case Prepare = 2;
    case BurnCard = 3;
    case ChoosingWhoStartsTheNextAge = 4;
    case PickBoardToken = 5;
    case PickDiscardedCard = 6;
    case PickRandomToken = 7;
    case PickReturnedCards = 8;
    case PickTopLineCard = 9;
}
