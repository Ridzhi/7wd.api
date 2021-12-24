<?php

namespace App\Infra\Http;

use App\Error\EmailAlreadyInUseError;
use App\Error\MaxAttemptsRegistrationReachedError;
use App\Handler\SendEmailVerificationHandler;
use App\Infra\Http\Request\SendEmailVerificationRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/email-verification', methods: ['POST'])]
class SendEmailVerificationEndpoint extends AbstractController
{
    /**
     * @throws MaxAttemptsRegistrationReachedError
     * @throws EmailAlreadyInUseError
     */
    public function __invoke(
        SendEmailVerificationRequest $request,
        SendEmailVerificationHandler $handler,
    ): Response
    {
        return $this->json([
            'id' => $handler($request->getEmail())->getId(),
        ]);
    }
}
