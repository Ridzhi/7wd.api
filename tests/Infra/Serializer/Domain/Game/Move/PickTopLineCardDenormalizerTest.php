<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Infra\Serializer\Domain\Game\Move as Denormalizer;

class PickTopLineCardDenormalizerTest extends AbstractTest
{
    public function factoryMove(): object
    {
        return new Move\PickTopLineCard(
            card: Cid::Altar,
        );
    }

    public function getMoveClassname(): string
    {
        return Move\PickTopLineCard::class;
    }

    public function getNormalizerClassname(): string
    {
        return Denormalizer\PickTopLineCardDenormalizer::class;
    }
}
