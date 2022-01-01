<?php

namespace App\Domain\Game\State;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;

class DialogItems
{
    /**
     * @param array<Wid> $wonders
     * @param array<Cid> $cards
     * @param array<Tid> $tokens
     */
    public function __construct(
        public array $wonders = [],
        public array $cards = [],
        public array $tokens = [],
    )
    {
    }
}
