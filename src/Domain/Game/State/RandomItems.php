<?php

namespace App\Domain\Game\State;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;

class RandomItems
{
    /**
     * @param array<Tid> $tokens
     * @param array<Wid> $wonders
     * @param array<int, array<Cid>> $cards Age->value => [Cid,...]
     */
    public function __construct(
        public array $tokens,
        public array $wonders,
        public array $cards,
    )
    {
    }
}
