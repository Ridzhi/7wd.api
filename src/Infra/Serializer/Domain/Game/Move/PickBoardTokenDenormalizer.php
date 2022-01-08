<?php

namespace App\Infra\Serializer\Domain\Game\Move;

use App\Domain\Game\Move;
use App\Domain\Game\Token\Id as Tid;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PickBoardTokenDenormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        return new Move\PickBoardToken(
            token: Tid::from($data['token']),
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Move\PickBoardToken::class;
    }
}
