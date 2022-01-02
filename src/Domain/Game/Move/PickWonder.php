<?php

namespace App\Domain\Game\Move;

use App\Domain\Game\Age;
use App\Domain\Game\Deck;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\Phase;
use App\Domain\Game\Rule;
use App\Domain\Game\State\State;
use App\Domain\Game\Wonder\Id as Wid;
use LogicException;

class PickWonder implements MutatorInterface
{
    public readonly Id $id;

    public function __construct(
        public readonly Wid $wonder,
    )
    {
        $this->id = Id::PickWonder;
    }

    /**
     * @throws InvalidError
     */
    public function mutate(State $state): void
    {
        if ($state->phase !== Phase::Prepare) {
            throw new InvalidError();
        }

        if (!in_array($this->wonder, $state->dialogItems->wonders)) {
            throw new InvalidError();
        }

        $state->me->wonders->add($this->wonder);

        $totalPicked = $state->me->wonders->countTotal() + $state->enemy->wonders->countTotal();

        /**
         * pick scheme
         * [N] - player
         * stage 1: [1][2][2][1]
         * stage 2: [2][1][1][2]
         */
        switch ($totalPicked) {
            case 2:
            case 6:
                // pick two wonders in a row
                break;
            default:
                // normal flow, next turn
                $state->nextTurn();
        }

        switch ($totalPicked) {
            case Rule::WONDERS_POOL_SIZE:
                $state->dialogItems->wonders = array_slice(
                    $state->randomItems->wonders,
                    -Rule::WONDERS_POOL_SIZE,
                );
                break;
            case Rule::WONDERS_POOL_SIZE * 2:
                $state->phase = Phase::Turn;
                $state->dialogItems->wonders = [];
                $state->deck = new Deck(
                    cards: $state->randomItems->cards[Age::I->value],
                );
                $state->refreshCardItems();
                $state->refreshCities();

                break;
            default:
                throw new LogicException('PickWonder unexpected switch case');
        }
    }
}
