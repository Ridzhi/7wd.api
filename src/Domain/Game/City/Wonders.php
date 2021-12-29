<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Wonder\Id as Wid;

class Wonders
{
    public array $list = [];

    public array $constructed = [];

    public function add(Wid $wid): void
    {
        $this->list[] = $wid->value;
        $this->constructed[$wid->value] = Cid::Null->value;
    }

    public function has(Wid $wid): bool
    {
        return isset($this->constructed[$wid->value]);
    }

    public function isConstructed(Wid $wid): bool
    {
        return $this->has($wid) && ($this->constructed[$wid->value] != Cid::Null->value);
    }

    public function construct(Wid $wid, Cid $cid): void
    {
        $this->constructed[$wid->value] = $cid->value;
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
