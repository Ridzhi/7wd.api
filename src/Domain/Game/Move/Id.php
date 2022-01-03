<?php

namespace App\Domain\Game\Move;

enum Id: int
{
    case Prepare = 1;
    case PickWonder = 2;
    case PickBoardToken = 3;
    case ConstructCard = 4;
    case ConstructWonder = 5;
    case DiscardCard = 6;
    case SelectWhoStartsTheNextAge = 7;
    case BurnCard = 8;
    case PickRandomToken = 9;
    case PickTopLineCard = 10;
    case PickDiscardedCard = 11;
    case PickReturnedCards = 12;

    /**
     * @return class-string
     */
    public function classname(): string
    {
        return match ($this) {
            self::Prepare => Prepare::class,
            self::PickWonder => PickWonder::class,
            self::SelectWhoStartsTheNextAge => SelectWhoStartsTheNextAge::class,
            self::PickBoardToken => PickBoardToken::class,
            self::PickRandomToken => PickRandomToken::class,
        };
    }
}
