<?php

namespace App\Infra\Endpoint;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ping')]
class PingEndpoint
{
    public function __invoke(): Response
    {
        $a = 5;

        return new JsonResponse([
            'ping' => 'pong',
        ]);
    }
}
