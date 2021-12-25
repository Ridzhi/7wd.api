<?php

namespace App\Infra\Messenger;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'async')]
class UpdateRoomHandler extends AbstractCentrifugoHandler
{
    public function __invoke(UpdateRoomMessage $message): void
    {
        $this->publish(Channel::UpdRoom, $message->getRoom());
    }
}
