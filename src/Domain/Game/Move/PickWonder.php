<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Wonder\Id as Wid;

class PickWonder
{
    public readonly Id $id;

    public function __construct(
        public readonly Wid $wonder,
    )
    {
        $this->id = Id::PickWonder;
    }
}
