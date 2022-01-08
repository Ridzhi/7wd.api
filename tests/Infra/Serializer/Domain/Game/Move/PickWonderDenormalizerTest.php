<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Move;
use App\Domain\Game\Wonder\Id as Wid;
use App\Infra\Serializer\Domain\Game\Move as Denormalizer;

/**
 * @coversDefaultClass \App\Infra\Serializer\Domain\Game\Move\PickWonderDenormalizer
 */
class PickWonderDenormalizerTest extends AbstractTest
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
        return Denormalizer\PickWonderDenormalizer::class;
    }
}
