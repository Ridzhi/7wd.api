<?php

namespace App\Infra\Http;

use App\Domain\Game\Card\Repository as CardRepository;
use App\Domain\Game\Wonder\Repository as WonderRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/game/units', methods: ['GET'])]
class GetGameUnitsEndpoint
{
    /**
     * @throws ExceptionInterface
     */
    public function __invoke(NormalizerInterface $normalizer): Response
    {
        return new JsonResponse([
            'cards' => $normalizer->normalize(
                CardRepository::getAll(),
                'array',
            ),
            'wonders' => $normalizer->normalize(
                WonderRepository::getAll(),
                'array',
            ),
        ]);
    }
}
