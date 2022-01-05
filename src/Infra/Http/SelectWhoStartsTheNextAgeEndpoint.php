<?php

namespace App\Infra\Http;

use App\Domain\Game\Move\InvalidError;
use App\Domain\Game\Move\SelectWhoStartsTheNextAge;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Handler\MoveHandler;
use App\Infra\Http\Request\SelectWhoStartsTheNextAgeRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/game/select-move', methods: ['POST'])]
class SelectWhoStartsTheNextAgeEndpoint
{
    /**
     * @throws ExceptionInterface
     * @throws InvalidError
     * @throws NotFoundError
     */
    public function __invoke(
        SelectWhoStartsTheNextAgeRequest $request,
        Passport                         $passport,
        MoveHandler                      $handler,

    ): Response
    {
        $handler(
            $passport,
            $request->getGameId(),
            new SelectWhoStartsTheNextAge(
                player: $request->getPlayer(),
            )
        );

        return new JsonResponse();
    }
}
