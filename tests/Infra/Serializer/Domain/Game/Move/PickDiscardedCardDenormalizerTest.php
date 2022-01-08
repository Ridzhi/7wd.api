<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Infra\Serializer\Domain\Game\Move as Denormalizer;

class PickDiscardedCardDenormalizerTest extends AbstractTest
{
    public function factoryMove(): object
    {
        return new Move\PickDiscardedCard(
            card: Cid::Altar,
        );
    }

    public function getMoveClassname(): string
    {
        return Move\PickDiscardedCard::class;
    }

    public function getNormalizerClassname(): string
    {
        return Denormalizer\PickDiscardedCardDenormalizer::class;
    }
}
