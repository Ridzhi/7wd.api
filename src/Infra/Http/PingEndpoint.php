<?php

namespace App\Infra\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ping', methods: ['GET'])]
class PingEndpoint
{
    public function __invoke(): Response
    {
        return new JsonResponse([
            'ping' => 'pong',
        ]);
    }
}
