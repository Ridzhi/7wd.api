<?php

namespace App\Infra\Http;

use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Error\RoomError;
use App\Handler\LeaveRoomHandler;
use App\Infra\Http\Request\LeaveRoomRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/room/leave', methods: ['POST'])]
class LeaveRoomEndpoint
{
    /**
     * @throws NotFoundError
     * @throws RoomError
     */
    public function __invoke(
        LeaveRoomRequest $request,
        Passport         $passport,
        LeaveRoomHandler $leaveRoomHandler,
    ): Response
    {
        $leaveRoomHandler($passport, $request->getHost());

        return new JsonResponse();
    }
}
