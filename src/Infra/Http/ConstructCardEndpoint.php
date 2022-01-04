<?php

namespace App\Infra\Http;

use App\Domain\Game\Move\ConstructCard;
use App\Domain\Game\Move\InvalidError;
use App\Domain\Passport;
use App\Error\NotFoundError;
use App\Handler\MoveHandler;
use App\Infra\Http\Request\ConstructCardRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/game/construct-card', methods: ['POST'])]
class ConstructCardEndpoint
{
    /**
     * @throws ExceptionInterface
     * @throws InvalidError
     * @throws NotFoundError
     */
    public function __invoke(
        ConstructCardRequest $request,
        Passport             $passport,
        MoveHandler          $handler,
    ): Response
    {
        $handler(
            $passport,
            $request->getGid(),
            new ConstructCard(card: $request->getCid()),
        );

        return new JsonResponse();
    }
}
