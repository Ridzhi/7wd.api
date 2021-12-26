<?php

namespace App\Handler;

use App\Domain\Game\Game;
use App\Domain\Passport;
use App\Domain\PlayerRepository;
use App\Domain\RoomRepository;
use App\Error\NotFoundError;
use App\Error\RoomError;
use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;

class CreateGameHandler
{
    public function __construct(
        private RoomRepository $roomRepository,
        private PlayerRepository $playerRepository,
        private EntityManagerInterface $em,
    )
    {
    }

    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(Passport $passport)
    {
        $room = $this->roomRepository->get($passport->getNickname());

        if (!$room->getGuest()) {
            throw new RoomError('cant start game without opponent');
        }

        $guest = $this->playerRepository->findByNickname($room->getGuest());

        if (!$guest) {
            throw new NotFoundError($guest, 'guest');
        }

        $host = $this->playerRepository->get($passport->getId());

        $game = (new Game())
            ->setHostNickname($host->getNickname())
            ->setHostRating($host->getRating())
            ->setGuestNickname($guest->getNickname())
            ->setGuestRating($guest->getRating())
            ->setMoves([])
            ->setStartedAt(CarbonImmutable::now());

        $this->em->persist($game);
        $this->em->flush();
    }
}
