<?php

namespace App\Tests\Infra\Serializer\Move\Normalizer;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractTest extends KernelTestCase
{
    abstract function factoryMove(): object;

    /**
     * @return class-string
     */
    abstract function getMoveClassname(): string;

    /**
     * @return class-string
     */
    abstract function getNormalizerClassname(): string;

    /**
     * @covers ::denormalize
     * @covers ::supportsDenormalization
     * @throws ExceptionInterface
     * @throws ExceptionInterface
     */
    public function testDenormalize(): void
    {
        self::bootKernel();

        $normalizerClassname = $this->getNormalizerClassname();
        $serializer = new Serializer([
            new $normalizerClassname,
        ]);

        $orig = $this->factoryMove();

        // getting doctrine representation
        $array = static
            ::getContainer()
            ->get(SerializerInterface::class)
            ->normalize($orig);

        $this->assertEquals(
            $orig,
            $serializer->denormalize($array, $this->getMoveClassname()),
        );
    }
}
