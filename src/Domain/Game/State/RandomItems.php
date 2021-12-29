<?php

namespace App\Domain\Game\State;

use App\Domain\Game\Age;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;
use SplObjectStorage;

class RandomItems
{
    /**
     * @var array<Wid>
     */
    public array $wonders = [];

    /**
     * @var SplObjectStorage<Age, array<Cid>>
     */
    public SplObjectStorage $cards;

    /**
     * @var array<Tid>
     */
    public array $tokens = [];
}
