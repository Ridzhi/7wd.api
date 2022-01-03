<?php

namespace App\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use App\Domain\Game\Wonder\Id as Wid;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ConstructWonder implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        return new Move\ConstructWonder(
            wonder: Wid::from($data['wonder']),
            card: Cid::from($data['card']),
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Move\ConstructWonder::class;
    }
}
