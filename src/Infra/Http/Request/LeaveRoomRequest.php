<?php

namespace App\Infra\Http\Request;

use App\Infra\Validator as Check;
use Symfony\Component\Validator\Constraints;

class LeaveRoomRequest
{
    #[
        Constraints\NotBlank(message: 'host is required'),
        Check\Nickname
    ]
    private ?string $host;

    public function __construct(array $params)
    {
        $this->host = $params['host'] ?? null;
    }

    public function getHost(): string
    {
        return $this->host;
    }
}
