<?php

namespace App\Infra\Http\Request;

use App\Infra\Validator as Check;

class SelectWhoStartsTheNextAgeRequest
{
    #[Check\Game]
    private ?int $gid;

    #[Check\Nickname]
    private ?string $player;

    public function __construct(array $params)
    {
        $this->gid = $params['gid'] ?? null;
        $this->player = $params['player'] ?? null;
    }

    public function getGameId(): int
    {
        return $this->gid;
    }

    public function getPlayer(): string
    {
        return $this->player;
    }
}
