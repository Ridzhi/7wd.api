<?php

namespace App\Infra\Http\Request;

use App\Domain\Game\Card\Id as Cid;
use App\Infra\Validator as Check;

class ConstructCardRequest
{
    #[Check\GameId]
    private ?int $gid;

    #[Check\CardId]
    private ?int $cid;

    public function __construct(array $params)
    {
        $this->gid = $params['gid'] ?? null;
        $this->cid = $params['cid'] ?? null;
    }

    /**
     * @return int
     */
    public function getGid(): int
    {
        return $this->gid;
    }

    public function getCid(): Cid
    {
        return Cid::from($this->cid);
    }
}
