<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Token\Id as Tid;

class Tokens
{
    public array $list = [];

    public function add(Tid $token): void
    {
        $this->list[] = $token->value;
    }

    public function has(Tid $token): bool
    {
        return in_array($token->value, $this->list);
    }
}
