<?php

namespace App\Handler;

use App\Domain\Passport;
use App\Domain\PlayerRepository;
use App\Domain\Room;
use App\Domain\RoomOptions;
use App\Domain\RoomRepository;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Infra\Messenger\NewRoomMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateRoomHandler
{
    public function __construct(
        private PlayerRepository $playerRepository,
        private RoomRepository $roomRepository,
        private MessageBusInterface $bus,
    )
    {
    }

    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(Passport $passport, RoomOptions $roomOptions): Room
    {
        if ($enemyName = $roomOptions->getEnemy()) {
            $enemy = $this->playerRepository->findByNickname($enemyName);

            if (!$enemy) {
                throw new NotFoundError($enemyName, 'room enemy');
            }

            if($enemy->getNickname() === $passport->getNickname()) {
                throw new RoomError('you can\'t play with yourself');
            }
        }

        $room = $this->roomRepository->find($passport->getNickname());

        if ($room) {
            throw new RoomError("one room per player");
        }

        $room = new Room($passport->getNickname(), $roomOptions);
        $this->roomRepository->persist($room);

        $this->bus->dispatch(new NewRoomMessage($room));

        return $room;
    }
}
