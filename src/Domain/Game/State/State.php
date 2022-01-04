<?php

namespace App\Domain\Game\State;

use App\Domain\Game\Age;
use App\Domain\Game\City\City;
use App\Domain\Game\Deck;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Victory;
use Symfony\Component\Serializer\Annotation\Ignore;

class State
{
    public Age $age;
    public Phase $phase = Phase::Null;
    /** @var array<Tid> */
    public array $tokens;
    // always indicates whose move
    public City $me;
    // always indicates whose wait
    public City $enemy;
    public CardItems $cardItems;
    public DialogItems $dialogItems;

    public ?string $winner = null;
    public ?Victory $victory = null;

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

    public function over(Victory $victory, ?string $winner = null): void
    {
        $this->phase = Phase::Over;

        $this->me->refreshScore($this);
        $this->enemy->refreshScore($this);

        if ($winner === null) {
            $winner = match (true) {
                $this->me->score->total !== $this->enemy->score->total
                => ($this->me->score->total > $this->enemy->score->total)
                    ? $this->me->name
                    : $this->enemy->name,
                $this->me->score->civilian !== $this->enemy->score->civilian
                => ($this->me->score->civilian > $this->enemy->score->civilian)
                    ? $this->me->name
                    : $this->enemy->name,
                default
                => ($this->me->name === $this->firstTurn)
                    ? $this->enemy->name
                    : $this->me->name,
            };
        }

        $this->winner = $winner;
        $this->victory = $victory;
    }

    public function after(): void
    {
        if ($this->isOver()) {
            return;
        }

        if (
            $this->deck->isEmpty()
            && $this->age === Age::III
            && $this->phase === Phase::Turn
            && count($this->dialogs) === 0
        ) {
            $this->over(Victory::Civilian);
            return;
        }

        $this->resolveTurn();

        $hasDialogs = count($this->dialogs) > 0;

        if (
            !$hasDialogs
            && ($this->deck->isEmpty() && $this->age !== Age::III)
        ) {
            $this->age = $this->age->next();
            $this->deck = new Deck($this->randomItems->cards[$this->age->value]);
        }

        $this->refreshCardItems();
        $this->refreshCities();

        if ($hasDialogs) {
            if ($this->fallbackTurn === null) {
                $this->fallbackTurn = $this->me->name;
            }

            array_shift($this->dialogs)->mutate($this);
        } elseif ($this->fallbackTurn) {
            if ($this->phase !== Phase::SelectWhoStartsTheNextAge) {
                $this->phase = Phase::Turn;
                $this->setTurn($this->fallbackTurn);
            }

            $this->fallbackTurn = null;
        }
    }

    public function isOver(): bool
    {
        return $this->phase === Phase::Over;
    }

    protected function resolveTurn(): void
    {
        if ($this->deck->isEmpty()) {
            if ($this->me->track->pos === $this->enemy->track->pos) {
                return;
            }

            $this->phase = Phase::SelectWhoStartsTheNextAge;

            $this->setTurn(
                $this->me->track->pos > $this->enemy->track->pos
                    ? $this->enemy->name
                    : $this->me->name
            );

            return;
        }

        if ($this->playAgain) {
            $this->playAgain = false;

            return;
        }

        $this->nextTurn();
    }
}
