<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Card\Id;

class Chains
{
    public array $list = [];

    public function add(Id $card): void
    {
        $this->list[] = $card;
    }

    public function has(Id $card): bool
    {
        return in_array($card, $this->list);
    }
}
