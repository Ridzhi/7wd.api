<?php

namespace App\Infra\Http;

use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Handler\CreateGameHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game', methods: ['POST'])]
class CreateGameEndpoint
{
    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(
        Passport $passport,
        CreateGameHandler $handler,
    ): Response
    {
        $handler($passport);

        return new JsonResponse();
    }
}
