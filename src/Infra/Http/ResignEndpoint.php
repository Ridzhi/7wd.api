<?php

namespace App\Infra\Http;

use App\Domain\Game\Move\InvalidError;
use App\Domain\Game\Move\Over;
use App\Domain\Game\Victory;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Handler\MoveHandler;
use App\Infra\Http\Request\ResignRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/game/resign', methods: ['POST'])]
class ResignEndpoint
{
    /**
     * @throws ExceptionInterface
     * @throws InvalidError
     * @throws NotFoundError
     */
    public function __invoke(
        ResignRequest $request,
        Passport      $passport,
        MoveHandler   $handler,
    ): Response
    {
        $handler(
            $passport,
            $request->getGameId(),
            new Over(
                loser: $passport->getNickname(),
                victory: Victory::Resign,
            ),
        );

        return new JsonResponse();
    }
}
