<?php

namespace App\Infra\Http;

use Carbon\CarbonInterval;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/config', methods: ['GET'])]
class GetConfigEndpoint extends AbstractController
{
    public function __invoke(
        CarbonInterval $refreshTokenTtl,
    ): Response
    {
        return $this->json([
            'refreshTokenTtl' => $refreshTokenTtl->totalSeconds,
        ]);
    }
}
