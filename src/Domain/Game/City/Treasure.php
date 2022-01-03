<?php

namespace App\Domain\Game\City;

class Treasure
{
    private const DEFAULT_COINS = 7;

    public int $coins = self::DEFAULT_COINS;

    public function change(int $diff): void
    {
        $this->coins += $diff;

        if ($this->coins < 0) {
            $this->coins = 0;
        }
    }
}
