<?php

namespace App\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Move;
use App\Domain\Game\Wonder\Id as Wid;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PickWonderDenormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
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
