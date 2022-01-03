<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Move;
use App\Domain\Game\Victory;
use App\Infra\Serializer\Move\Normalizer;

class OverTest extends AbstractTest
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
        return Normalizer\Over::class;
    }
}
