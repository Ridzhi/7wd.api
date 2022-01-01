<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Age;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;
use App\Infra\Serializer\Move\Normalizer;

/**
 * @coversDefaultClass \App\Infra\Serializer\Move\Normalizer\Prepare
 */
class PrepareTest extends AbstractTest
{
    function factoryMove(): object
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

    function getMoveClassname(): string
    {
        return Move\Prepare::class;
    }

    function getNormalizerClassname(): string
    {
        return Normalizer\Prepare::class;
    }
}
