<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Wonder\Id as Wid;

class Wonders
{
    public array $list = [];

    public array $constructed = [];

    public function add(Wid $wonder): void
    {
        $this->list[] = $wonder->value;
        $this->constructed[$wonder->value] = Cid::Null->value;
    }

    public function has(Wid $wonder): bool
    {
        return isset($this->constructed[$wonder->value]);
    }

    public function isConstructed(Wid $wonder): bool
    {
        return $this->has($wonder) && ($this->constructed[$wonder->value] != Cid::Null->value);
    }

    public function construct(Wid $wonder, Cid $card): void
    {
        $this->constructed[$wonder->value] = $card->value;
    }

    public function countTotal(): int
    {
        return count($this->list);
    }

    public function countConstructed(): int
    {
        return count(array_filter(
            $this->constructed,
            fn($value) => $value !== Cid::Null->value),
        );
    }

    public function removeNotConstructed(): void
    {
        $filtered = [];

        foreach ($this->list as $wonder) {
            if ($this->constructed[$wonder] === Cid::Null) {
                unset($this->constructed[$wonder]);
            } else {
                $filtered[] = $wonder;
            }
        }

        $this->list = $filtered;
    }
}
