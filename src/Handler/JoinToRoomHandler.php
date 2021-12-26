<?php

namespace App\Handler;

use App\Domain\Passport;
use App\Domain\RoomRepository;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Infra\Messenger\UpdateRoomMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class JoinToRoomHandler
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
    public function __invoke(Passport $passport, string $host)
    {
        $actor = $passport->getNickname();

        if ($actor === $host) {
            throw new RoomError('cant join to yourself');
        }

        $rooms = $this->roomRepository->findAll();

        $targetRoom = null;

        foreach ($rooms as $room) {
            if ($room->getHost() === $host) {
                $targetRoom = $room;
            }

            if ($actor === $room->getHost() || $actor === $room->getGuest()) {
                throw new RoomError('you have already joined to room');
            }
        }

        if (!$targetRoom) {
            throw new RoomError("$host no have rooms");
        }

        if ($targetRoom->getGuest()) {
            throw new RoomError('room is occupied');
        }

        $expectedEnemy = $targetRoom->getOptions()->getEnemy();

        if ($expectedEnemy && $expectedEnemy !== $actor) {
            throw new RoomError("this is private game, expect $expectedEnemy");
        }

        $this->roomRepository->update($targetRoom->setGuest($actor));

        $this->bus->dispatch(new UpdateRoomMessage($targetRoom));
    }
}
