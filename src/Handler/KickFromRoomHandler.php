<?php

namespace App\Handler;

use App\Domain\Passport;
use App\Domain\RoomRepository;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Infra\Messenger\UpdateRoomMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class KickFromRoomHandler
{
    public function __construct(
        private RoomRepository $roomRepository,
        private MessageBusInterface $bus,
    )
    {
    }

    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(Passport $passport): void
    {
        $room = $this->roomRepository->find($passport->getNickname());

        if (!$room) {
            throw new RoomError('you have no rooms');
        }

        if (!$room->getGuest()) {
            throw new RoomError('room is empty');
        }

        $this->roomRepository->update($room->setGuest(null));

        $this->bus->dispatch(new UpdateRoomMessage($room));
    }
}
