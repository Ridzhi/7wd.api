<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Card\Id;
use App\Domain\Game\Card\Repository;
use App\Domain\Game\Card\Group;
use SplObjectStorage;

class Cards
{
    public SplObjectStorage $data;

    public function __construct()
    {
        $this->data = new SplObjectStorage();
    }

    public function add(Id $card): void
    {
        $card = Repository::get($card);

        if (!isset($this->data[$card->group])) {
            $this->data[$card->group] = [];
        }

        $this->data[$card->group][] = $card->id;
    }

    public function remove(Id $card): void
    {
        $card = Repository::get($card);

        $pos = array_search($card->id, $this->data[$card->group], true);
        unset($this->data[$card->group][$pos]);
    }

    public function count(Group $type): int
    {
        return count($this->data[$type]);
    }

    /**
     * @return array<Id>
     */
    public function get(Group $type): array
    {
        return $this->data[$type] ?? [];
    }
}
