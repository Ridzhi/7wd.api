<?php

namespace App\Domain\Game\Effect;

enum Id: int
{
    case AdjustDiscardReward = 1;
    case BurnCard = 2;
    case Chain = 3;
    case Coins = 4;
    case CoinsFor = 5;
    case Discounter = 6;
    case Fine = 7;
    case FixedCost = 8;
    case Guild = 9;
    case Mathematics = 10;
    case Military = 11;
    case PickBoardToken = 12;
    case PickDiscardedCard = 13;
    case PickRandomToken = 14;
    case PickReturnedCards = 15;
    case PickTopLineCard = 16;
    case PlayAgain = 17;
    case Points = 18;
    case Resource = 19;
    case Science = 20;
}
