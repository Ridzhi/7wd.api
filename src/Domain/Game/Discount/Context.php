<?php

namespace App\Domain\Game\Discount;

use App\Domain\Game\Card\Id;
use App\Domain\Game\Card\Repository;
use App\Domain\Game\Card\Type;

enum Context: int
{
    case Global = 1;
    case Civilian = 2;
    case Wonder = 3;

    public static function byCard(Id $card): self
    {
        return Repository::get($card)->type === Type::Civilian
            ? self::Civilian
            : self::Global;
    }
}
