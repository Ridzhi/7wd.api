<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Move;
use App\Infra\Serializer\Move\Normalizer;

/**
 * @coversDefaultClass \App\Infra\Serializer\Move\Normalizer\PickBoardToken
 */
class PickBoardTokenTest extends AbstractTest
{
    public function factoryMove(): object
    {
        return new Move\PickBoardToken(Tid::Mathematics);
    }

    public function getMoveClassname(): string
    {
        return Move\PickBoardToken::class;
    }

    public function getNormalizerClassname(): string
    {
        return Normalizer\PickBoardToken::class;
    }
}
