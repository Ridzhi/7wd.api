<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Age;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;
use App\Infra\Serializer\Move\Normalizer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @coversDefaultClass \App\Infra\Serializer\Move\Normalizer\Prepare
 */
class PrepareTest extends KernelTestCase
{
    /**
     * @covers ::denormalize
     * @covers ::supportsDenormalization
     * @throws ExceptionInterface
     */
    public function testDenormalize(): void
    {
        self::bootKernel();

        $serializer = new Serializer([
            new Normalizer\Prepare(),
        ]);

        $orig = new Move\Prepare(
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

        // getting doctrine representation
        $array = static
            ::getContainer()
            ->get(SerializerInterface::class)
            ->normalize($orig);

        $this->assertEquals(
            $orig,
            $serializer->denormalize($array, Move\Prepare::class),
        );
    }
}
