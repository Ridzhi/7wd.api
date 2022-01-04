<?php

namespace App\Infra\Http;

use App\Domain\Game\Move\InvalidError;
use App\Domain\Game\Move\PickTopLineCard;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Handler\MoveHandler;
use App\Infra\Http\Request\PickTopLineCardRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/game/pick-topline-card', methods: ['POST'])]
class PickTopLineCardEndpoint
{
    /**
     * @throws InvalidError
     * @throws ExceptionInterface
     * @throws NotFoundError
     */
    public function __invoke(
        PickTopLineCardRequest $request,
        Passport               $passport,
        MoveHandler            $handler,

    ): Response
    {
        $handler(
            $passport,
            $request->getGameId(),
            new PickTopLineCard(card: $request->getCardId()),
        );

        return new JsonResponse();
    }
}
