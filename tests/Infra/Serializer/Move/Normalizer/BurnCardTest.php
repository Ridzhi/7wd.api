<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Infra\Serializer\Move\Normalizer;

class BurnCardTest extends AbstractTest
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
        return Normalizer\BurnCard::class;
    }
}
