<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Infra\Serializer\Move\Normalizer;

class PickTopLineCardTest extends AbstractTest
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
        return Normalizer\PickTopLineCard::class;
    }
}
