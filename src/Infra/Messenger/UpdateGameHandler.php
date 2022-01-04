<?php

namespace App\Infra\Messenger;

use App\Infra\Centrifugo\Channel;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsMessageHandler(fromTransport: 'async')]
class UpdateGameHandler extends AbstractCentrifugoHandler
{
    /**
     * @param UpdateGameMessage $message
     * @return void
     * @throws ExceptionInterface
     */
    public function __invoke(UpdateGameMessage $message): void
    {
        $this->publish(
            Channel::UpdGame,
            $message->getState(),
            [$message->getId()],
        );
    }
}
