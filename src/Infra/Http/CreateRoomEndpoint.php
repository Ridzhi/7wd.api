<?php

namespace App\Infra\Http;

use App\Domain\Passport;
use App\Domain\RoomOptions;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Handler\CreateRoomHandler;
use App\Infra\Http\Request\CreateRoomRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/room', methods: ['POST'])]
class CreateRoomEndpoint
{
    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(
        CreateRoomRequest $request,
        Passport          $passport,
        CreateRoomHandler $createRoomHandler,
    ): Response
    {
        $createRoomHandler(
            $passport,
            new RoomOptions(
                fast: $request->getFast(),
                minRating: $request->getMinRating(),
                enemy: $request->getEnemy(),
            ),
        );

        return new JsonResponse();
    }
}
