<?php

namespace App\Infra\Http;

use App\Domain\Game\Move\InvalidError;
use App\Domain\Game\Move\PickDiscardedCard;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Handler\MoveHandler;
use App\Infra\Http\Request\PickDiscardedCardRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/game/pick-discarded-card', methods: ['POST'])]
class PickDiscardedCardEndpoint
{
    /**
     * @throws ExceptionInterface
     * @throws InvalidError
     * @throws NotFoundError
     */
    public function __invoke(
        PickDiscardedCardRequest $request,
        Passport                 $passport,
        MoveHandler              $handler,
    ): Response
    {
        $handler(
            $passport,
            $request->getGameId(),
            new PickDiscardedCard(card: $request->getCardId()),
        );

        return new JsonResponse();
    }
}
