<?php

namespace App\Domain\Game\Effect;

abstract class Base
{
    public function __construct(
        public readonly Id $id,
    )
    {
    }
}
