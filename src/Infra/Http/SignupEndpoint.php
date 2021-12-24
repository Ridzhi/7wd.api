<?php

namespace App\Infra\Http;

use App\Error\NotVerifiedEmailError;
use App\Handler\CreatePlayerHandler;
use App\Infra\Http\Request\SignupRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/signup', methods: ['POST'])]
class SignupEndpoint extends AbstractController
{
    /**
     * @throws NotVerifiedEmailError
     */
    public function __invoke(
        SignupRequest $request,
        CreatePlayerHandler $handler,
    ): Response
    {
        return $this->json([
            'id' => $handler(
                $request->getEmail(),
                $request->getPassword(),
                $request->getCode(),
                $request->getNickname(),
            )->getId(),
        ]);
    }
}
