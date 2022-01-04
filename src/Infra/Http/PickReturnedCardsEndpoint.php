<?php

namespace App\Infra\Http;

use App\Domain\Game\Move\InvalidError;
use App\Domain\Game\Move\PickReturnedCards;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Handler\MoveHandler;
use App\Infra\Http\Request\PickReturnedCardsRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/game/pick-returned-cards', methods: ['POST'])]
class PickReturnedCardsEndpoint
{
    /**
     * @throws ExceptionInterface
     * @throws InvalidError
     * @throws NotFoundError
     */
    public function __invoke(
        PickReturnedCardsRequest $request,
        Passport                 $passport,
        MoveHandler              $handler,
    ): Response
    {
        $handler(
            $passport,
            $request->getGameId(),
            new PickReturnedCards(
                pick: $request->getPick(),
                give: $request->getGive(),
            )
        );

        return new JsonResponse();
    }
}
