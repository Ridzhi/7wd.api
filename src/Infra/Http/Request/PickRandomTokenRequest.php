<?php

namespace App\Infra\Http\Request;

use App\Domain\Game\Token\Id as Tid;
use App\Infra\Validator as Check;

class PickRandomTokenRequest
{
    #[Check\Game]
    private ?int $gid;

    #[Check\Token]
    private ?int $tid;

    public function __construct(array $params)
    {
        $this->gid = $params['gid'] ?? null;
        $this->tid = $params['tid'] ?? null;
    }

    public function getGameId(): int
    {
        return $this->gid;
    }

    public function getTokenId(): Tid
    {
        return Tid::from($this->tid);
    }
}
