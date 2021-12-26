<?php

namespace App\Infra\Http;

use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Handler\DeleteRoomHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * One room per player, we can request without any params,
 * because room.id = host nickname
 */
#[Route('/room', methods: ['DELETE'])]
class DeleteRoomEndpoint
{
    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(
        Passport          $passport,
        DeleteRoomHandler $deleteRoomHandler,
    ): Response
    {
        $deleteRoomHandler($passport);

        return new JsonResponse();
    }
}
