<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Move;
use App\Domain\Game\Token\Id as Tid;
use App\Infra\Serializer\Move\Normalizer;

class PickRandomTokenTest extends AbstractTest
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
        return Normalizer\PickRandomToken::class;
    }
}
