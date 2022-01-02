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

    public function setTurn(string $name): void
    {
        if ($this->enemy->name === $name) {
            $this->nextTurn();
        }
    }

    public function nextTurn(): void
    {
        list($this->me, $this->enemy) = [$this->enemy, $this->me];
    }

    public function refreshCardItems(): void
    {
        $this->cardItems->layout = $this->deck->getLayout();
        $this->cardItems->playable = $this->deck->getPlayableCards();
    }

    public function refreshCities(): void
    {
        $origTurn = $this->me->name;

        foreach ([$this->me->name, $this->enemy->name] as $name) {
            // change city context for correct calculations uses me, enemy aliases
            $this->setTurn($name);
            $this->me->refreshCardsPrice($this->cardItems->playable);
            $this->me->refreshWondersPrice();
            $this->me->refreshScore($this);
        }

        $this->setTurn($origTurn);
    }
}
