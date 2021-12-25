<?php

namespace App\Infra\Messenger;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'async')]
class DeleteRoomHandler extends AbstractCentrifugoHandler
{
    public function __invoke(DeleteRoomMessage $message): void
    {
        $this->publish(Channel::DelRoom, $message);
    }
}
