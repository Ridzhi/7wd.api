<?php

namespace App\Infra\Http;

use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Handler\JoinToRoomHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/room/{host}/join', methods: ['POST'])]
class JoinToRoomEndpoint
{
    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(
        string            $host,
        Passport          $passport,
        JoinToRoomHandler $joinToRoomHandler,
    ): Response
    {
        $joinToRoomHandler($passport, $host);

        return new JsonResponse();
    }
}
