<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Bonus;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Card\Repository as CardRepository;
use App\Domain\Game\Card\Type;
use App\Domain\Game\Cost;
use App\Domain\Game\Discount\Context;
use App\Domain\Game\Move\InvalidError;
use App\Domain\Game\Resource\Storage;
use App\Domain\Game\Rule;
use App\Domain\Game\State\State;
use App\Domain\Game\Token\Id as Tid;
use App\Domain\Game\Token\Repository as TokenRepository;
use App\Domain\Game\Wonder\Repository as WonderRepository;
use SplObjectStorage;

class City
{
    public function __construct(
        public            readonly string $name,
        public Storage    $resources = new Storage(),
        public Wonders    $wonders = new Wonders(),
        public Tokens     $tokens = new Tokens(),
        public Symbols    $symbols = new Symbols(),
        public Cards      $cards = new Cards(),
        public Treasure   $treasure = new Treasure(),
        public Chains     $chains = new Chains(),
        public Track      $track = new Track(),
        public Discounter $discounter = new Discounter(),
        public Bank       $bank = new Bank(),
        public ?Score     $score = null,
    )
    {
    }

    /**
     * @param array<Cid> $cards
     */
    public function refreshCardsPrice(array $cards): void
    {
        $prices = new SplObjectStorage();

        foreach ($cards as $card) {
            if ($this->chains->has($card)) {
                $prices[$card] = 0;
                continue;
            }

            $prices[$card] = $this->getFinalPrice(
                Context::byCard($card),
                CardRepository::get($card)->cost,
            );
        }

        $this->bank->cardPrice = $prices;
    }

    public function refreshWondersPrice(): void
    {
        $prices = new SplObjectStorage();

        foreach ($this->wonders->getNotConstructed() as $wid) {
            $prices[$wid] = $this->getFinalPrice(
                Context::Wonder,
                WonderRepository::get($wid)->cost,
            );
        }

        $this->bank->wonderPrice = $prices;
    }

    public function refreshScore(State $state): void
    {
        $score = new Score();

        foreach ($this->cards->data as $type => $cards) {
            foreach ($cards as $cid) {
                $card = CardRepository::get($cid);
                $points = $card->getPoints($state);

                switch ($type) {
                    case Type::Civilian:
                        $score->civilian += $points;
                        break;
                    case Type::Science:
                        $score->science += $points;
                        break;
                    case Type::Commercial:
                        $score->commercial += $points;
                        break;
                    case Type::Guild:
                        $score->guilds += $points;
                        break;
                }
            }
        }

        foreach ($this->wonders->getConstructed() as $wid) {
            $score->wonders += WonderRepository::get($wid)->getPoints($state);
        }

        foreach ($this->tokens->list as $tid) {
            $score->tokens += TokenRepository::get($tid)->getPoints($state);
        }

        $score->coins = intdiv($this->treasure->coins, Rule::COINS_PER_POINT);
        $score->military = $this->track->getPoints();

        $score->total = $score->civilian
            + $score->science
            + $score->commercial
            + $score->guilds
            + $score->wonders
            + $score->tokens
            + $score->coins
            + $score->military;

        $this->score = $score;
    }

    public function pay(Context $context, Cost $cost, City $enemy): void
    {
        $price = $this->getFinalPrice($context, $cost);

        if ($price > $this->treasure->coins) {
            throw new InvalidError();
        }

        $this->treasure->change(-$price);

        if ($enemy->tokens->has(Tid::Economy)) {
            $enemy->treasure->change($price - $cost->coins);
        }
    }

    public function getBonusRate(Bonus $bonus): int
    {
        return match ($bonus) {
            Bonus::Resources => $this->cards->count(Type::RawMaterials) + $this->cards->count(Type::ManufacturedGoods),
            Bonus::RawMaterials => $this->cards->count(Type::RawMaterials),
            Bonus::ManufacturedGoods => $this->cards->count(Type::ManufacturedGoods),
            Bonus::Military => $this->cards->count(Type::Military),
            Bonus::Commercial => $this->cards->count(Type::Commercial),
            Bonus::Civilian => $this->cards->count(Type::Civilian),
            Bonus::Science => $this->cards->count(Type::Science),
            Bonus::Wonder => $this->wonders->countConstructed(),
            Bonus::Coin => intdiv($this->treasure->coins, Rule::COINS_PER_POINT),
        };
    }

    protected function getFinalPrice(Context $context, Cost $cost): int
    {
        $cost = clone $cost;

        array_walk($cost->resources, function (&$count, $rid) {
            if (isset($this->resources[$rid])) {
                $count = max($count - $this->resources[$rid], 0);
            }
        });

        $price = $cost->coins;

        $this->discounter->discount($context, $cost->resources, $this->bank->resourcePrice);

        foreach ($cost->resources as $rid => $count) {
            $price += ($count * $this->bank->resourcePrice[$rid]);
        }

        return $price;
    }
}
