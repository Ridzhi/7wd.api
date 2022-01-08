<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Infra\Serializer\Domain\Game\Move as Denormalizer;

class BurnCardDenormalizerTest extends AbstractTest
{
    public function factoryMove(): object
    {
        return new Move\BurnCard(
            card: Cid::Altar,
        );
    }

    public function getMoveClassname(): string
    {
        return Move\BurnCard::class;
    }

    public function getNormalizerClassname(): string
    {
        return Denormalizer\BurnCardDenormalizer::class;
    }
}
