<?php

namespace App\Infra\Http;

use App\Domain\Game\GameRepository;
use App\Domain\Game\State\Factory;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Infra\Http\Request\GetGameRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game', methods: ['GET'])]
class GetGameEndpoint
{
    /**
     * @throws NotFoundError
     */
    public function __invoke(
        GetGameRequest $request,
        Passport       $passport,
        GameRepository $gameRepository,
        Factory        $stateFactory,
    ): Response
    {
        $game = $gameRepository->get($request->getGameId());

        return new JsonResponse([
            'id' => $game->getId(),
            'hostNickname' => $game->getHostNickname(),
            'hostRating' => $game->getHostRating(),
            'guestNickname' => $game->getGuestNickname(),
            'guestRating' => $game->getGuestRating(),
            'state' => $stateFactory->factory($game),
        ]);
    }
}
