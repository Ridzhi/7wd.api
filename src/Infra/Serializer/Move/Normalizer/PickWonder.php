<?php

namespace App\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Wonder\Id as Wid;
use App\Domain\Game\Move;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PickWonder implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        return new Move\PickWonder(
            wonder: Wid::from($data['wonder']),
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Move\PickWonder::class;
    }
}
