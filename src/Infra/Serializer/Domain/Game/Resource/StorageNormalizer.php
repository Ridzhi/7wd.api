<?php

namespace App\Infra\Serializer\Domain\Game\Resource;

use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Resource\Storage;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class StorageNormalizer implements NormalizerInterface, DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        $object = new Storage();

        foreach ($data as $rid => $count) {
            $object[Rid::from($rid)] = $count;
        }

        return $object;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Storage::class;
    }

    public function normalize(mixed $object, string $format = null, array $context = []): mixed
    {
        $data = [];

        foreach (Rid::cases() as $rid) {
            if (isset($object[$rid])) {
                $data[$rid->value] = $object[$rid];
            }
        }

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Storage;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
