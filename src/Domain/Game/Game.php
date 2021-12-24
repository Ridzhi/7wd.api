<?php

namespace App\Domain\Game;

use Carbon\CarbonImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 15)]
    private string $host_nickname;

    #[ORM\Column(type: 'smallint')]
    private int $host_rating;

    #[ORM\Column(type: 'string', length: 15)]
    private string $guest_nickname;

    #[ORM\Column(type: 'smallint')]
    private int $guest_rating;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private ?string $winner;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private ?int $victory;

    #[ORM\Column(type: 'json',options: ['jsonb' => true])]
    private array $moves = [];

    #[ORM\Column(type: 'datetime_immutable')]
    private CarbonImmutable $started_at;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?CarbonImmutable $finished_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function getHostNickname(): string
    {
        return $this->host_nickname;
    }

    public function setHostNickname(string $host_nickname): self
    {
        $this->host_nickname = $host_nickname;

        return $this;
    }

    public function getHostRating(): int
    {
        return $this->host_rating;
    }

    public function setHostRating(int $host_rating): self
    {
        $this->host_rating = $host_rating;

        return $this;
    }

    public function getGuestNickname(): string
    {
        return $this->guest_nickname;
    }

    public function setGuestNickname(string $guest_nickname): self
    {
        $this->guest_nickname = $guest_nickname;

        return $this;
    }

    public function getGuestRating(): int
    {
        return $this->guest_rating;
    }

    public function setGuestRating(int $guest_rating): self
    {
        $this->guest_rating = $guest_rating;

        return $this;
    }

    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function setWinner(?string $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getVictory(): ?Victory
    {
        return Victory::from($this->victory);
    }

    public function setVictory(?Victory $victory): self
    {
        $this->victory = $victory->value;

        return $this;
    }

    public function getMoves(): array
    {
        return $this->moves;
    }

    public function getStartedAt(): CarbonImmutable
    {
        return $this->started_at;
    }

    public function setStartedAt(CarbonImmutable $started_at): self
    {
        $this->started_at = $started_at;

        return $this;
    }

    public function getFinishedAt(): ?CarbonImmutable
    {
        return $this->finished_at;
    }

    public function setFinishedAt(?CarbonImmutable $finished_at): self
    {
        $this->finished_at = $finished_at;

        return $this;
    }

    public function move(ActionInterface $move)
    {
        $move->update();

        $this->moves[] = $move;
    }
}
