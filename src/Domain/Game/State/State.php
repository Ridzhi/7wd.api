<?php

namespace App\Domain\Game\State;

use App\Domain\Game\Age;
use App\Domain\Game\City\City;
use App\Domain\Game\Deck;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\Token\Id as Tid;
use Symfony\Component\Serializer\Annotation\Ignore;

class State
{
    public Age $age;
    public Phase $phase = Phase::Null;
    /** @var array<Tid> */
    public array $tokens;
    public City $me;
    public City $enemy;
    public CardItems $cardItems;
    public DialogItems $dialogItems;

    #[Ignore]
    public string $firstTurn;

    /**
     * @var array<MutatorInterface>
     */
    #[Ignore]
    public array $dialogs = [];

    #[Ignore]
    public bool $playAgain = false;

    #[Ignore]
    public ?string $fallbackTurn = null;

    #[Ignore]
    public RandomItems $randomItems;

    #[Ignore]
    public ?Deck $deck = null;
}
