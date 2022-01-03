<?php

namespace App\Domain\Game\Move;

enum Id: int
{
    case BurnCard = 1;
    case ConstructCard = 2;
    case ConstructWonder = 3;
    case DiscardCard = 4;
    case Over = 5;
    case PickBoardToken = 6;
    case PickDiscardedCard = 7;
    case PickRandomToken = 8;
    case PickReturnedCards = 9;
    case PickTopLineCard = 10;
    case PickWonder = 11;
    case Prepare = 12;
    case SelectWhoStartsTheNextAge = 13;

    /**
     * @return class-string
     */
    public function classname(): string
    {
        return match ($this) {
            self::BurnCard => BurnCard::class,
            self::ConstructCard => ConstructCard::class,
            self::ConstructWonder => ConstructWonder::class,
            self::DiscardCard => DiscardCard::class,
            self::Over => Over::class,
            self::PickBoardToken => PickBoardToken::class,
            self::PickDiscardedCard => PickDiscardedCard::class,
            self::PickRandomToken => PickRandomToken::class,
            self::PickReturnedCards => PickReturnedCards::class,
            self::PickTopLineCard => PickTopLineCard::class,
            self::PickWonder => PickWonder::class,
            self::Prepare => Prepare::class,
            self::SelectWhoStartsTheNextAge => SelectWhoStartsTheNextAge::class,
        };
    }
}
