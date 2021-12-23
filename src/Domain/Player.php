<?php

namespace App\Domain;

use App\Domain\Attr\CreatedAtAttribute;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[
    ORM\Entity(repositoryClass: PlayerRepository::class),
    ORM\HasLifecycleCallbacks,
]
class Player implements PasswordAuthenticatedUserInterface
{
    use CreatedAtAttribute;

    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column(type: 'integer'),
    ]
    private int $id;

    #[ORM\Column(type: 'citext', unique: true)]
    private string $nickname;

    #[ORM\Column(type: 'string', length: 40, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'smallint')]
    private int $rating;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
