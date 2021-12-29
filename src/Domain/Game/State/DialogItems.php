<?php

namespace App\Domain\Game\State;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;

class DialogItems
{
    /**
     * @var array<Wid>
     */
    public array $wonders = [];

    /**
     * @var array<Cid>
     */
    public array $cards = [];

    /**
     * @var array<Tid>
     */
    public array $tokens = [];
}
