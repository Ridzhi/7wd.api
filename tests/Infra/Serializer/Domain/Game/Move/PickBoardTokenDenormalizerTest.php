<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Move;
use App\Domain\Game\Token\Id as Tid;
use App\Infra\Serializer\Domain\Game\Move as Denormalizer;

/**
 * @coversDefaultClass \App\Infra\Serializer\Domain\Game\Move\PickBoardTokenDenormalizer
 */
class PickBoardTokenDenormalizerTest extends AbstractTest
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
        return Denormalizer\PickBoardTokenDenormalizer::class;
    }
}
