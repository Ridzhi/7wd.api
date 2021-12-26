<?php

namespace App\Handler;

use App\Domain\Passport;
use App\Domain\RoomRepository;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Infra\Messenger\UpdateRoomMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class LeaveRoomHandler
{
    public function __construct(
        private RoomRepository      $roomRepository,
        private MessageBusInterface $bus,
    )
    {
    }

    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(Passport $passport, string $host): void
    {
        $actor = $passport->getNickname();

        if ($actor === $host) {
            throw new RoomError('you cant leave yourself room, only close');
        }

        $room = $this->roomRepository->find($host);

        if (!$room) {
            throw new RoomError('room not found');
        }

        if ($actor !== $room->getGuest()) {
            throw new RoomError('you are not a guest');
        }

        $this->roomRepository->update($room->setGuest(null));

        $this->bus->dispatch(new UpdateRoomMessage($room));
    }
}
