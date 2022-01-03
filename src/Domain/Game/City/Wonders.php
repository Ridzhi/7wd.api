<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Wonder\Id as Wid;
use SplObjectStorage;

class Wonders
{
    /**
     * @var array<Wid>
     */
    public array $list = [];

    public SplObjectStorage $constructed;

    public function __construct()
    {
        $this->constructed = new SplObjectStorage();
    }

    public function add(Wid $wonder): void
    {
        $this->list[] = $wonder;
        $this->constructed[$wonder] = Cid::Null;
    }

    public function has(Wid $wonder): bool
    {
        return isset($this->constructed[$wonder]);
    }

    public function construct(Wid $wonder, Cid $card): void
    {
        $this->constructed[$wonder] = $card;
    }

    public function countTotal(): int
    {
        return count($this->list);
    }

    public function countConstructed(): int
    {
        return count($this->getConstructed());
    }

    public function isConstructed(Wid $wonder): bool
    {
        return $this->constructed[$wonder] !== Cid::Null;
    }

    /**
     * @return array<Wid>
     */
    public function getConstructed(): array
    {
        $result = [];

        foreach ($this->constructed as $wid => $cid) {
            if ($cid !== Cid::Null) {
                $result[] = $wid;
            }
        }

        return $result;
    }

    /**
     * @return array<Wid>
     */
    public function getNotConstructed(): array
    {
        $result = [];

        foreach ($this->constructed as $wid => $cid) {
            if ($cid === Cid::Null) {
                $result[] = $wid;
            }
        }

        return $result;
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
