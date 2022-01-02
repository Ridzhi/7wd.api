<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Bonus;
use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Card\Repository as CardRepo;
use App\Domain\Game\Card\Type;
use App\Domain\Game\Cost;
use App\Domain\Game\Discount\Context;
use App\Domain\Game\Resource\Storage;
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
                CardRepo::get($card)->cost,
            );
        }

        $this->bank->cardPrice = $prices;
    }

    public function getFinalPrice(Context $context, Cost $cost): int
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
            Bonus::Coin => intdiv($this->treasure->coins, Score::COINS_PER_POINT),
        };
    }
}
