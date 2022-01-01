<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Age;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\City\City;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\Rule;
use App\Domain\Game\State\DialogItems;
use App\Domain\Game\State\RandomItems;
use App\Domain\Game\State\State;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Wonder\Id as Wid;

/**
 * Initial game setup + the entire random to reproduce state
 */
class Prepare implements MutatorInterface
{
    public readonly Id $id;

    /**
     * @param string $p1
     * @param string $p2
     * @param array<Wid> $wonders
     * @param array<Tid> $tokens
     * @param array<Tid> $randomTokens usage by The Great Library wonder
     * @param array<int, array<Cid>> $cards age -> cards list
     */
    public function __construct(
        public readonly string $p1,
        public readonly string $p2,
        public readonly array $wonders,
        public readonly array $tokens,
        public readonly array $randomTokens,
        public readonly array $cards,
    )
    {
        $this->id = Id::Prepare;
    }

    public function mutate(State $state): void
    {
        if ($state->phase !== Phase::Null) {
            throw new InvalidError();
        }

        $state->age = Age::I;
        $state->phase = Phase::Prepare;
        $state->firstTurn = $this->p1;
        $state->tokens = $this->tokens;
        $state->me = new City(name: $this->p1);
        $state->enemy = new City(name: $this->p2);

        $state->randomItems = new RandomItems(
            tokens: $this->randomTokens,
            wonders: $this->wonders,
            cards: $this->cards,
        );

        $state->dialogItems = new DialogItems(
            wonders: array_slice($this->wonders, 0, Rule::WONDERS_POOL_SIZE)
        );
    }
}
