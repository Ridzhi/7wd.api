<?php

namespace App\Domain\Game\State;

use App\Domain\Game\Age;
use App\Domain\Game\City\City;
use App\Domain\Game\Phase;
use App\Domain\Game\Token\Id as Tid;
use Symfony\Component\Serializer\Annotation\Ignore;

class State
{
    public Age $age;

    public Phase $phase;

    #[Ignore]
    public string $firstTurn;

    /** @var array<Tid>  */
    public array $tokens;

    public City $me;
    public City $enemy;
}
