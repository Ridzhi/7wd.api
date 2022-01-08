<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Age;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;
use App\Infra\Serializer\Domain\Game\Move as Denormalizer;

/**
 * @coversDefaultClass \App\Infra\Serializer\Domain\Game\Move\PrepareDenormalizer
 */
class PrepareDenormalizerTest extends AbstractTest
{
    public function factoryMove(): object
    {
        return new Move\Prepare(
            p1: 'Player1',
            p2: 'Player2',
            wonders: [
                Wid::CircusMaximus,
                Wid::Messe,
            ],
            tokens: [
                Tid::Urbanism,
                Tid::Theology,
            ],
            randomTokens: [
                Tid::Strategy,
                Tid::Mathematics,
            ],
            cards: [
                Age::I->value => [
                    Cid::LumberYard,
                    Cid::LoggingCamp,
                ],
                Age::II->value => [
                    Cid::SawMill,
                    Cid::BrickYard,
                ],
                Age::III->value => [
                    Cid::Arsenal,
                    Cid::MerchantsGuild,
                ],
            ],
        );
    }

    public function getMoveClassname(): string
    {
        return Move\Prepare::class;
    }

    public function getNormalizerClassname(): string
    {
        return Denormalizer\PrepareDenormalizer::class;
    }
}
