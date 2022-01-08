<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Move;
use App\Domain\Game\Token\Id as Tid;
use App\Infra\Serializer\Domain\Game\Move as Denormalizer;

class PickRandomTokenDenormalizerTest extends AbstractTest
{
    public function factoryMove(): object
    {
        return new Move\PickRandomToken(Tid::Mathematics);
    }

    public function getMoveClassname(): string
    {
        return Move\PickRandomToken::class;
    }

    public function getNormalizerClassname(): string
    {
        return Denormalizer\PickRandomTokenDenormalizer::class;
    }
}
