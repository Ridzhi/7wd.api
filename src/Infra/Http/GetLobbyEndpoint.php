<?php

namespace App\Infra\Http;

use App\Domain\RoomRepository;
use App\Infra\Centrifugo\OnlineWatcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lobby', methods: ['GET'])]
class GetLobbyEndpoint extends AbstractController
{
    public function __invoke(
        RoomRepository $roomRepository,
        OnlineWatcher  $onlineWatcher,
    ): Response
    {
        return new JsonResponse([
            'rooms' => $roomRepository->findAll(),
            'online' => $onlineWatcher->watch(),
        ]);
    }
}
