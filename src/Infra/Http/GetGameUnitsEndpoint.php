<?php

namespace App\Infra\Http;

use App\Domain\Game\Card\Repository as CardRepository;
use App\Domain\Game\Wonder\Repository as WonderRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game/units', methods: ['GET'])]
class GetGameUnitsEndpoint
{
    public function __invoke(): Response
    {
        return new JsonResponse([
            'cards' => CardRepository::getAll(),
            'wonders' => WonderRepository::getAll(),
        ]);
    }
}
