<?php

namespace App\Infra\Http;

use App\Domain\PlayerRepository;
use App\Handler\CreateSessionHandler;
use App\Infra\Http\Request\SigninRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

#[Route('/signin', methods: ['POST'])]
class SigninEndpoint extends AbstractController
{
    public function __invoke(
        SigninRequest               $request,
        UserPasswordHasherInterface $hasher,
        PlayerRepository   $playerRepository,
        CreateSessionHandler        $createSessionHandler,
    ): Response
    {
        $player = $playerRepository->findByEmail($request->getEmail());

        if (!$player) {
            throw new BadCredentialsException();
        }

        if (!$hasher->isPasswordValid($player, $request->getPassword())) {
            throw new BadCredentialsException();
        }

        return $this->json(
            $createSessionHandler($player, $request->getFingerprint()),
        );
    }
}
