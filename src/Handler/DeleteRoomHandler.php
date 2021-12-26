<?php

namespace App\Handler;

use App\Domain\Passport;
use App\Domain\RoomRepository;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Infra\Messenger\DeleteRoomMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteRoomHandler
{
    public function __construct(
        private RoomRepository $roomRepository,
        private MessageBusInterface     $bus,
    )
    {
    }

    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(Passport $passport): void
    {
        $nickname = $passport->getNickname();
        $room = $this->roomRepository->find($nickname);

        if (!$room) {
            throw new RoomError('room not found');
        }

        if ($room->getGameId() !== null) {
            throw new RoomError('game already started');
        }

        $this->roomRepository->remove($nickname);

        $this->bus->dispatch(new DeleteRoomMessage($nickname));
    }
}
