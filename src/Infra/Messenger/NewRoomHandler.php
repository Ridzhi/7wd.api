<?php

namespace App\Infra\Messenger;

use App\Infra\Centrifugo\Channel;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler(fromTransport: 'async')]
class NewRoomHandler extends AbstractCentrifugoHandler
{
    /**
     * @throws ExceptionInterface
     */
    public function __invoke(NewRoomMessage $message): void
    {
        $this->publish(Channel::NewRoom, $message->getRoom());
    }
}
