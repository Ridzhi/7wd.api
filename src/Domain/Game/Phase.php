<?php

namespace App\Domain\Game;

enum Phase: int
{
    case Null = 0;

    case BurnCard = 1;
    case Over = 2;
    case PickBoardToken = 3;
    case PickDiscardedCard = 4;
    case PickRandomToken = 5;
    case PickReturnedCards = 6;
    case PickTopLineCard = 7;
    case Prepare = 8;
    case SelectWhoStartsTheNextAge = 9;
    case Turn = 10;
}
