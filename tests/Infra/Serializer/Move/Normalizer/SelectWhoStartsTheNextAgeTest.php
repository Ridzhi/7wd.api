<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Move;
use App\Infra\Serializer\Move\Normalizer;

class SelectWhoStartsTheNextAgeTest extends AbstractTest
{
    function factoryMove(): object
    {
        return new Move\SelectWhoStartsTheNextAge(player: 'Player1');
    }

    function getMoveClassname(): string
    {
        return Move\SelectWhoStartsTheNextAge::class;
    }

    function getNormalizerClassname(): string
    {
        return Normalizer\SelectWhoStartsTheNextAge::class;
    }
}
