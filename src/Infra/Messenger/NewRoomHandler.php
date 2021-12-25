<?php

namespace App\Infra\Messenger;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'async')]
class NewRoomHandler extends AbstractCentrifugoHandler
{
    public function __invoke(NewRoomMessage $message): void
    {
        $this->publish(Channel::NewRoom, $message->getRoom());
    }
}
