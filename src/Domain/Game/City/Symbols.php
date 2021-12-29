<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Symbol;
use App\Domain\Game\SymbolStatus;

class Symbols
{
    public array $data = [];
    public array $order = [];

    private const TOKEN_COUNT = 2;
    private const SUPREMACY_COUNT = 2;

    public function add(Symbol $symbol): SymbolStatus
    {
        if (!isset($this->data[$symbol->value])) {
            $this->data[$symbol->value] = 0;
            $this->order[] = $symbol->value;
        }

        $this->data[$symbol->value]++;

        if (count($this->data[$symbol->value]) === self::TOKEN_COUNT) {
            return SymbolStatus::Token;
        }

        if (count($this->data) === self::SUPREMACY_COUNT) {
            return SymbolStatus::Supremacy;
        }

        return SymbolStatus::Null;
    }
}
