<?php

namespace App\Infra\Http\Request;

use App\Domain\Game\Card\Id as Cid;
use App\Infra\Validator as Check;

class PickReturnedCardsRequest
{
    #[Check\Game]
    private ?int $gid;

    #[Check\Card]
    private ?int $pick;

    #[Check\Card]
    private ?int $give;

    public function __construct(array $params)
    {
        $this->gid = $params['gid'] ?? null;
        $this->pick = $params['pick'] ?? null;
        $this->give = $params['give'] ?? null;
    }

    public function getGameId(): int
    {
        return $this->gid;
    }

    public function getPick(): Cid
    {
        return Cid::from($this->pick);
    }

    public function getGive(): Cid
    {
        return Cid::from($this->give);
    }
}
