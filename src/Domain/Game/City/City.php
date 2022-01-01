<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Bonus;
use App\Domain\Game\Card\Type;
use App\Domain\Game\Resource\Storage;

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