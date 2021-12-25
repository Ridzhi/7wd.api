<?php

namespace App\Infra\Security;

use App\Domain\Passport;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PassportProvider
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
    )
    {
    }

    public function factory(): Passport
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return new Passport($user->getId(), $user->getUserIdentifier());
    }
}
