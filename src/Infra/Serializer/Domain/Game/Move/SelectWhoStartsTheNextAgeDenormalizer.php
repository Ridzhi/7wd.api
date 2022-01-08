<?php

namespace App\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Move;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class SelectWhoStartsTheNextAgeDenormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        return new Move\SelectWhoStartsTheNextAge(
            player: $data['player'],
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Move\SelectWhoStartsTheNextAge::class;
    }
}
