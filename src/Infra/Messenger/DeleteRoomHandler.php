<?php

namespace App\Infra\Messenger;

use App\Infra\Centrifugo\Channel;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler(fromTransport: 'async')]
class DeleteRoomHandler extends AbstractCentrifugoHandler
{
    /**
     * @throws ExceptionInterface
     */
    public function __invoke(DeleteRoomMessage $message): void
    {
        $this->publish(Channel::DelRoom, $message);
    }
}
