<?php

namespace App\Infra\Http;

use App\Domain\Game\Move\ConstructWonder;
use App\Domain\Game\Move\InvalidError;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Handler\MoveHandler;
use App\Infra\Http\Request\ConstructWonderRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/game/construct-wonder', methods: ['POST'])]
class ConstructWonderEndpoint
{
    /**
     * @throws ExceptionInterface
     * @throws InvalidError
     * @throws NotFoundError
     */
    public function __invoke(
        ConstructWonderRequest $request,
        Passport               $passport,
        MoveHandler            $handler,
    ): Response
    {
        $handler(
            $passport,
            $request->getGameId(),
            new ConstructWonder(
                wonder: $request->getWonderId(),
                card: $request->getCardId(),
            )
        );

        return new JsonResponse();
    }
}
