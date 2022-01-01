<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Move;
use App\Domain\Game\Wonder\Id as Wid;
use App\Infra\Serializer\Move\Normalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @coversDefaultClass \App\Infra\Serializer\Move\Normalizer\PickWonder
 */
class PickWonderTest extends AbstractTest
{
    function factoryMove(): object
    {
        return new Move\PickWonder(Wid::Messe);
    }

    function getMoveClassname(): string
    {
        return Move\PickWonder::class;
    }

    function getNormalizerClassname(): string
    {
        return Normalizer\PickWonder::class;
    }
}
