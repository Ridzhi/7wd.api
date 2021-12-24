<?php

namespace App\Infra\Http;

use App\Error\InvalidCredentialsError;
use App\Error\NotFoundError;
use App\Error\SecurityError;
use App\Handler\RefreshSessionHandler;
use App\Infra\Http\Request\RefreshSessionRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/session', methods: ['POST'])]
class RefreshSessionEndpoint extends AbstractController
{
    /**
     * @throws NotFoundError
     * @throws SecurityError
     * @throws InvalidCredentialsError
     */
    public function __invoke(
        RefreshSessionRequest $request,
        RefreshSessionHandler $refreshSessionHandler,
    ): Response
    {
        return $this->json(
            $refreshSessionHandler(
                $request->getFingerprint(),
                $request->getRefreshToken(),
            ),
        );
    }
}
