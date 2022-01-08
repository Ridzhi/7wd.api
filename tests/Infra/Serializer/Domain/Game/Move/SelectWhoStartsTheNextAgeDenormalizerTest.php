<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Move;
use App\Infra\Serializer\Domain\Game\Move as Denormalizer;

class SelectWhoStartsTheNextAgeDenormalizerTest extends AbstractTest
{
    public function factoryMove(): object
    {
        return new Move\SelectWhoStartsTheNextAge(player: 'Player1');
    }

    public function getMoveClassname(): string
    {
        return Move\SelectWhoStartsTheNextAge::class;
    }

    public function getNormalizerClassname(): string
    {
        return Denormalizer\SelectWhoStartsTheNextAgeDenormalizer::class;
    }
}
