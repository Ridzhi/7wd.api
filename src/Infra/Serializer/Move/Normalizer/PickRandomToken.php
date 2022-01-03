<?php

namespace App\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Move;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PickRandomToken implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        return new Move\PickRandomToken(
            token: Tid::from($data['token']),
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Move\PickRandomToken::class;
    }
}
