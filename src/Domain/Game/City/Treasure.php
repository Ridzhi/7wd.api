<?php

namespace App\Domain\Game\City;

class Treasure
{
    private const DEFAULT_COINS = 7;

    public int $coins = self::DEFAULT_COINS;

    public function add(int $coins): void
    {
        $this->coins += $coins;

        if ($this->coins < 0) {
            $this->coins = 0;
        }
    }
}
