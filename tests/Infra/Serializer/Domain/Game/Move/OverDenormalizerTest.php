<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Move;
use App\Domain\Game\Victory;
use App\Infra\Serializer\Domain\Game\Move as Denormalizer;

class OverDenormalizerTest extends AbstractTest
{
    public function factoryMove(): object
    {
        return new Move\Over(
            loser: 'Player1',
            victory: Victory::Resign,
        );
    }

    public function getMoveClassname(): string
    {
        return Move\Over::class;
    }

    public function getNormalizerClassname(): string
    {
        return Denormalizer\OverDenormalizer::class;
    }
}
