<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Domain\Game\Wonder\Id as Wid;
use App\Infra\Serializer\Move\Normalizer;

class ConstructWonderTest extends AbstractTest
{
    public function factoryMove(): object
    {
        return new Move\ConstructWonder(
            wonder: Wid::Messe,
            card: Cid::Altar,
        );
    }

    public function getMoveClassname(): string
    {
        return Move\ConstructWonder::class;
    }

    public function getNormalizerClassname(): string
    {
        return Normalizer\ConstructWonder::class;
    }
}
