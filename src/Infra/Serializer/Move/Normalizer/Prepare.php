<?php

namespace App\Infra\Serializer\Move\Normalizer;

use App\Domain\Game\Age;
use \App\Domain\Game\Move;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Prepare implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        $cards = [];

        foreach (Age::cases() as $age) {
            $cards[$age->value] = array_map(fn($item) => Cid::from($item), $data['cards'][$age->value]);
        }

        return new Move\Prepare(
            p1: $data['p1'],
            p2: $data['p2'],
            wonders: array_map(fn($item) => Wid::from($item), $data['wonders']),
            tokens: array_map(fn($item) => Tid::from($item), $data['tokens']),
            randomTokens: array_map(fn($item) => Tid::from($item), $data['randomTokens']),
            cards: $cards,
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Move\Prepare::class;
    }
}
