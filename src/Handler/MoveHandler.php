<?php

namespace App\Handler;

use App\Domain\Game\GameRepository;
use App\Domain\Game\Move\InvalidError;
use App\Domain\Game\Move\Over;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\Factory;
use App\Domain\Game\State\State;
use App\Domain\Passport;
use App\Domain\RoomRepository;
use App\Error\NotFoundError;
use App\Infra\Messenger\UpdateGameMessage;
use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class MoveHandler
{
    public function __construct(
        private GameRepository         $gameRepository,
        private RoomRepository         $roomRepository,
        private Factory                $stateFactory,
        private EntityManagerInterface $em,
        private MessageBusInterface    $bus,
    )
    {
    }

    /**
     * @throws InvalidError
     * @throws NotFoundError
     */
    public function __invoke(Passport $passport, int $gid, MutatorInterface $move): void
    {
        $game = $this->gameRepository->get($gid);
        $state = $this->stateFactory->factory($game);

        $this->allowedOrFail($passport, $state, $move);

        $move->mutate($state);
        $game->addMove($move);

        if ($state->isOver()) {
            $game
                ->setWinner($state->winner)
                ->setVictory($state->victory)
                ->setFinishedAt(CarbonImmutable::now());

            $this->roomRepository->remove($game->getHostNickname());
        }

        $this->em->persist($game);
        $this->em->flush();

        $this->bus->dispatch(
            new UpdateGameMessage($game->getId(), $state),
        );
    }

    /**
     * @throws InvalidError
     */
    private function allowedOrFail(Passport $passport, State $state, MutatorInterface $move): void
    {
        // @TODO remove check for over, loser getting from $passport always
        if ($move instanceof Over) {
            if ($passport->getNickname() !== $move->loser) {
                throw new InvalidError();
            }
        } else {
            if ($passport->getNickname() !== $state->me->name) {
                throw new InvalidError();
            }
        }
    }
}
