<?php

namespace App\Infra\Http;

use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Handler\KickFromRoomHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/room/kick', methods: ['POST'])]
class KickFromRoomEndpoint
{
    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(
        Passport            $passport,
        KickFromRoomHandler $kickFromRoomHandler,
    ): Response
    {
        $kickFromRoomHandler($passport);

        return new JsonResponse();
    }
}
