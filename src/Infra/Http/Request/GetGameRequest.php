<?php

namespace App\Infra\Http\Request;

use App\Infra\Validator as Check;

class GetGameRequest
{
    #[Check\Game]
    private ?int $gid;

    public function __construct(array $params)
    {
        $this->gid = $params['gid'] ?? null;
    }

    public function getGameId(): int
    {
        return $this->gid;
    }
}
