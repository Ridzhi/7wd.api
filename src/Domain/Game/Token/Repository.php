<?php

namespace App\Domain\Game\Token;

class Repository
{
    /**
     * @var Token[]
     */
    public readonly array $data;

    public function __construct()
    {
        $this->data = [
            Id::Agriculture->value => new Token(Id::Agriculture, [

            ])
        ];
    }
}
