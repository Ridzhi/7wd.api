<?php

namespace App\Domain;

use Carbon\CarbonImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmailVerificationRepository::class)]
class EmailVerification
{
    /**
     * How many times user can send email verification
     *
     * @var int
     */
    public const MAX_ATTEMPTS = 5;

    /**
     * How long user can't perform registration if max attempts is reached
     *
     * @var int
     */
    public const BLOCK_PERIOD = 60 * 60;

    public const CODE_SIZE = 5;
    public const CODE_TTL = 60 * 10;

    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column(type: 'integer'),
    ]
    private int $id;

    #[ORM\Column(type: 'string', length: 40)]
    private string $email;

    #[ORM\Column(type: 'string', length: 5)]
    private string $code;

    #[ORM\Column(type: 'smallint')]
    private int $attempts;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?CarbonImmutable $blocked_until;

    #[ORM\Column(type: 'datetime_immutable', length: 0)]
    private CarbonImmutable $expires;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAttempts(): ?int
    {
        return $this->attempts;
    }

    public function setAttempts(int $attempts): self
    {
        $this->attempts = $attempts;

        return $this;
    }

    public function getBlockedUntil(): ?CarbonImmutable
    {
        return $this->blocked_until;
    }

    public function setBlockedUntil(?CarbonImmutable $blocked_until = null): self
    {
        $this->blocked_until = $blocked_until;

        return $this;
    }

    public function getExpires(): CarbonImmutable
    {
        return $this->expires;
    }

    public function setExpires(CarbonImmutable $expires): self
    {
        $this->expires = $expires;

        return $this;
    }
}
