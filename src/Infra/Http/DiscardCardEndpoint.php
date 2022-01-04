<?php

namespace App\Infra\Http;

use App\Domain\Game\Move\DiscardCard;
use App\Domain\Game\Move\InvalidError;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Handler\MoveHandler;
use App\Infra\Http\Request\DiscardCardRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/game/discard-card', methods: ['POST'])]
class DiscardCardEndpoint
{
    /**
     * @throws InvalidError
     * @throws ExceptionInterface
     * @throws NotFoundError
     */
    public function __invoke(
        DiscardCardRequest $request,
        Passport           $passport,
        MoveHandler        $handler,
    ): Response
    {
        $handler(
            $passport,
            $request->getGameId(),
            new DiscardCard(card: $request->getCardId()),
        );

        return new JsonResponse();
    }
}
