<?php

namespace App\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Move;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PickDiscardedCard implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        return new Move\PickDiscardedCard(
            card: Cid::from($data['card']),
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Move\PickDiscardedCard::class;
    }
}
