<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Domain\Game\Wonder\Id as Wid;
use App\Infra\Serializer\Domain\Game\Move as Denormalizer;

class ConstructWonderDenormalizerTest extends AbstractTest
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
        return Denormalizer\ConstructWonderDenormalizer::class;
    }
}
