<?php

namespace App\Infra\Http\Request;

use App\Domain\Game\Card\Id as Cid;
use App\Infra\Validator as Check;

class DiscardCardRequest
{
    #[Check\Game]
    private ?int $gid;

    #[Check\Card]
    private ?int $cid;

    public function __construct(array $params)
    {
        $this->gid = $params['gid'] ?? null;
        $this->cid = $params['cid'] ?? null;
    }

    public function getGameId(): int
    {
        return $this->gid;
    }

    public function getCardId(): Cid
    {
        return Cid::from($this->cid);
    }
}
