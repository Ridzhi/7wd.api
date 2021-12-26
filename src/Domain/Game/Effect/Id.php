<?php

namespace App\Domain\Game\Effect;

enum Id: int
{
    case BurnCard = 1;
    case Chain = 2;
    case Coins = 3;
    case CoinsFor = 4;
    case Discounter = 5;
    case Fine = 6;
    case FixedCost = 7;
    case Guild = 8;
    case Mathematics = 9;
    case Military = 10;
    case PickDiscardedCard = 11;
    case PickTopLineCard = 12;
    case PickReturnedCards = 13;
    case PickBoardToken = 14;
    case PickRandomToken = 15;
    case Science = 16;
    case Points = 17;
    case Resource = 18;
    case PlayAgain = 19;
    case AdjustDiscardReward = 20;
}
