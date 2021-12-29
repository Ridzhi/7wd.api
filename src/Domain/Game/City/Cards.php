<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Card\Card;
use App\Domain\Game\Card\Type;

class Cards
{
    public array $data = [];

    public function add(Card $card): void
    {
        if (!isset($this->data[$card->type->value])) {
            $this->data[$card->type->value] = [];
        }

        $this->data[$card->type->value][] = $card->id;
    }

    public function remove(Card $card): void
    {
        $pos = array_search($card->id, $this->data[$card->type->value], true);
        unset($this->data[$card->type->value][$pos]);
    }

    public function count(Type $type): int
    {
        return count($this->data[$type->value]);
    }
}
