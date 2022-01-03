<?php

namespace App\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Move;
use App\Domain\Game\Victory;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Over implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        return new Move\Over(
            loser: $data['loser'],
            victory: Victory::from($data['victory']),
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Move\Over::class;
    }
}
