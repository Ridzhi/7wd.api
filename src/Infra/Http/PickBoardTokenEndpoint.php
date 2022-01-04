<?php

namespace App\Infra\Http;

use App\Domain\Game\Move\InvalidError;
use App\Domain\Game\Move\PickBoardToken;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Handler\MoveHandler;
use App\Infra\Http\Request\PickBoardTokenRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/game/pick-board-token', methods: ['POST'])]
class PickBoardTokenEndpoint
{
    /**
     * @throws ExceptionInterface
     * @throws InvalidError
     * @throws NotFoundError
     */
    public function __invoke(
        PickBoardTokenRequest $request,
        Passport              $passport,
        MoveHandler           $handler,

    ): Response
    {
        $handler(
            $passport,
            $request->getGameId(),
            new PickBoardToken(token: $request->getTokenId()),
        );

        return new JsonResponse();
    }
}
