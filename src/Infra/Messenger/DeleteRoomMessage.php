<?php

namespace App\Infra\Messenger;

class DeleteRoomMessage
{
    public function __construct(
        private string $host
    )
    {
    }

    public function getHost(): string
    {
        return $this->host;
    }
}
