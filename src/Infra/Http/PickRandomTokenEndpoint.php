<?php

namespace App\Infra\Http;

use App\Domain\Game\Move\InvalidError;
use App\Domain\Game\Move\PickRandomToken;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Handler\MoveHandler;
use App\Infra\Http\Request\PickRandomTokenRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/game/pick-random-token', methods: ['POST'])]
class PickRandomTokenEndpoint
{
    /**
     * @throws ExceptionInterface
     * @throws InvalidError
     * @throws NotFoundError
     */
    public function __invoke(
        PickRandomTokenRequest $request,
        Passport               $passport,
        MoveHandler            $handler,
    ): Response
    {
        $handler(
            $passport,
            $request->getGameId(),
            new PickRandomToken(token: $request->getTokenId()),
        );

        return new JsonResponse();
    }
}
