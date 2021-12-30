<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;

/**
 * Initial game setup + the entire random to reproduce state
 */
class Prepare
{
    public Id $id;

    /**
     * @param string $p1
     * @param string $p2
     * @param array<Wid> $wonders
     * @param array<Tid> $tokens
     * @param array<Tid> $randomTokens usage by The Great Library wonder
     * @param array<int, array<Cid>> $cards age -> cards list
     */
    public function __construct(
        public readonly string $p1,
        public readonly string $p2,
        public readonly array $wonders,
        public readonly array $tokens,
        public readonly array $randomTokens,
        public readonly array $cards,
    )
    {
        $this->id = Id::Prepare;
    }
}
