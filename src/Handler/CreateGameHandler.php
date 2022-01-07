<?php

namespace App\Handler;

use App\Domain\Game\Game;
use App\Domain\Game\Move\PrepareFactory;
use App\Domain\Passport;
use App\Domain\PlayerRepository;
use App\Domain\RoomRepository;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Infra\Messenger\UpdateRoomMessage;
use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateGameHandler
{
    public function __construct(
        private RoomRepository         $roomRepository,
        private PlayerRepository       $playerRepository,
        private EntityManagerInterface $em,
        private PrepareFactory         $prepareFactory,
        private MessageBusInterface    $bus,
    )
    {
    }

    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(Passport $passport): void
    {
        $room = $this->roomRepository->get($passport->getNickname());

        if ($room->getGameId() !== null) {
            throw new RoomError('already played');
        }

        if (!$room->getGuest()) {
            throw new RoomError('opponent not found');
        }

        $guest = $this->playerRepository->findByNickname($room->getGuest());

        if (!$guest) {
            throw new RoomError('opponent not found');
        }

        $host = $this->playerRepository->get($passport->getId());

        $game = (new Game())
            ->setHostNickname($host->getNickname())
            ->setHostRating($host->getRating())
            ->setGuestNickname($guest->getNickname())
            ->setGuestRating($guest->getRating())
            ->setMoves([
                $this->prepareFactory->factory(
                    p1: $host->getNickname(),
                    p2: $guest->getNickname(),
                ),
            ])
            ->setStartedAt(CarbonImmutable::now());

        $this->em->persist($game);
        $this->em->flush();

        $room->setGameId($game->getId());

        $this->roomRepository->update($room);
        $this->bus->dispatch(new UpdateRoomMessage($room));
    }
}
