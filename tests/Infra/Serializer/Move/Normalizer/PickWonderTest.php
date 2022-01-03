<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Move;
use App\Domain\Game\Wonder\Id as Wid;
use App\Infra\Serializer\Move\Normalizer;

/**
 * @coversDefaultClass \App\Infra\Serializer\Move\Normalizer\PickWonder
 */
class PickWonderTest extends AbstractTest
{
    public function factoryMove(): object
    {
        return new Move\PickWonder(Wid::Messe);
    }

    public function getMoveClassname(): string
    {
        return Move\PickWonder::class;
    }

    public function getNormalizerClassname(): string
    {
        return Normalizer\PickWonder::class;
    }
}
