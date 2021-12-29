<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Card\Card;

class Chains
{
    public array $list = [];

    public function add(Card $card): void
    {
        $this->list[] = $card->id;
    }

    public function has(Card $card): bool
    {
        return in_array($card->id, $this->list);
    }
}
