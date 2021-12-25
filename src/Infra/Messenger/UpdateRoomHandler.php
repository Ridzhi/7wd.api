<?php

namespace App\Infra\Messenger;

use App\Infra\Centrifugo\Channel;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler(fromTransport: 'async')]
class UpdateRoomHandler extends AbstractCentrifugoHandler
{
    /**
     * @throws ExceptionInterface
     */
    public function __invoke(UpdateRoomMessage $message): void
    {
        $this->publish(Channel::UpdRoom, $message->getRoom());
    }
}
