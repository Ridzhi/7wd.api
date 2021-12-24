<?php

namespace App\Infra\Http;

use App\Error\EmailAlreadyInUseError;
use App\Error\ExpiredConfirmationCodeError;
use App\Error\InvalidConfirmationCodeError;
use App\Error\NotFoundError;
use App\Handler\CheckEmailVerificationHandler;
use App\Infra\Http\Request\CheckEmailVerificationRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/email-verification', methods: ['GET'])]
class CheckEmailVerificationEndpoint extends AbstractController
{
    /**
     * @param CheckEmailVerificationRequest $request
     * @param CheckEmailVerificationHandler $handler
     * @return Response
     * @throws EmailAlreadyInUseError
     * @throws NotFoundError
     * @throws ExpiredConfirmationCodeError
     * @throws InvalidConfirmationCodeError
     */
    public function __invoke(
        CheckEmailVerificationRequest $request,
        CheckEmailVerificationHandler $handler,
    ): Response
    {
        $handler($request->getEmail(), $request->getCode());

        return $this->json([]);
    }
}
