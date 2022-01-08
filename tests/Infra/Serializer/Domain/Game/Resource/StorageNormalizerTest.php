<?php

namespace App\Tests\Infra\Serializer\Domain\Game\Resource;

use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Resource\Storage;
use App\Infra\Serializer\Domain\Game\Resource\StorageNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @coversDefaultClass \App\Infra\Serializer\Domain\Game\Resource\StorageNormalizer
 */
class StorageNormalizerTest extends KernelTestCase
{
    /**
     * @covers ::normalize
     * @covers ::denormalize
     */
    public function testNormalizeDenormalize(): void
    {
        $object = new Storage();
        $object[Rid::Clay] = 2;
        $object[Rid::Papyrus] = 1;

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $array = $serializer->normalize($object);
        $this->assertEquals($object, $serializer->denormalize($array, Storage::class));
    }
}
