<?php

namespace App\Handler;

use App\Domain\Game\Game;
use App\Domain\Game\GameRepository;
use App\Domain\Game\Move\Id;
use App\Domain\Game\Move\InvalidError;
use App\Domain\Game\Move\Over;
use App\Domain\Game\MutatorInterface;
use App\Domain\Game\State\State;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Infra\Messenger\UpdateGameMessage;
use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class MoveHandler
{
    public function __construct(
        private GameRepository         $gameRepository,
        private EntityManagerInterface $em,
        private MessageBusInterface    $bus,
        private DenormalizerInterface  $moveDenormalizer,
    )
    {
    }

    /**
     * @throws InvalidError
     * @throws ExceptionInterface
     * @throws NotFoundError
     */
    public function __invoke(Passport $passport, int $gid, MutatorInterface $move): void
    {
        $game = $this->gameRepository->get($gid);
        $state = $this->reproduceState($game);

        $this->allowedOrFail($passport, $state, $move);

        $move->mutate($state);
        $game->addMove($move);

        if ($state->isOver()) {
            $game
                ->setWinner($state->winner)
                ->setVictory($state->victory)
                ->setFinishedAt(CarbonImmutable::now());
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

    /**
     * @throws ExceptionInterface
     */
    private function reproduceState(Game $game): State
    {
        $moves = array_map(
            fn($move) => $this
                ->moveDenormalizer
                ->denormalize(
                    $move,
                    Id::from($move['id'])->classname(),
                ),
            $game->getMoves(),
        );

        $state = new State();

        foreach ($moves as $m) {
            $m->mutate($state);
        }

        return $state;
    }
}
