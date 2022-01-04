<?php

namespace App\Infra\Http\Request;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Wonder\Id as Wid;
use App\Infra\Validator as Check;

class ConstructWonderRequest
{
    #[Check\Game]
    private ?int $gid;

    #[Check\Wonder]
    private ?int $wid;

    #[Check\Card]
    private ?int $cid;

    public function __construct(array $params)
    {
        $this->gid = $params['gid'] ?? null;
        $this->wid = $params['wid'] ?? null;
        $this->cid = $params['cid'] ?? null;
    }

    public function getGameId(): int
    {
        return $this->gid;
    }

    public function getWonderId(): Wid
    {
        return Wid::from($this->wid);
    }

    public function getCardId(): Cid
    {
        return Cid::from($this->cid);
    }
}
