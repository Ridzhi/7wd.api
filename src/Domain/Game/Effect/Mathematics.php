<?php

namespace App\Domain\Game\Effect;

use App\Domain\Game\ScorableInterface;
use App\Domain\Game\State\State;

class Mathematics extends Base implements ScorableInterface
{
    public function __construct()
    {
        parent::__construct(Id::Mathematics);
    }

    public function getPoints(State $state): int
    {
        //@TODO!
        return 0;
    }
}
