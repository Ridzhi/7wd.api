<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Token\Id as Tid;

class Tokens
{
    /**
     * @var array<Tid>
     */
    private array $list = [];

    public function add(Tid $token): void
    {
        $this->list[] = $token;
    }

    public function count(): int
    {
        return count($this->list);
    }

    public function has(Tid $token): bool
    {
        return in_array($token, $this->list);
    }

    public function get(): array
    {
        return $this->list;
    }
}
