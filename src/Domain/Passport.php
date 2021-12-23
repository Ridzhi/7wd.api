<?php

namespace App\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class Passport implements UserInterface
{
    public function __construct(
        private int    $id,
        private string $nickname,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getUserIdentifier(): string
    {
        return $this->nickname;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials()
    {
    }
}
