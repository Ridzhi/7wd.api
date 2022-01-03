<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Infra\Serializer\Move\Normalizer;

class PickReturnedCardsTest extends AbstractTest
{

    public function factoryMove(): object
    {
        return new Move\PickReturnedCards(
            pick: Cid::Altar,
            give: Cid::SawMill,
        );
    }

    public function getMoveClassname(): string
    {
        return Move\PickReturnedCards::class;
    }

    public function getNormalizerClassname(): string
    {
        return Normalizer\PickReturnedCards::class;
    }
}
