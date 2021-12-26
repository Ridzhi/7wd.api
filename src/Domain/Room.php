<?php

namespace App\Domain;

class Room
{
    /**
     * Not null if game started
     */
    private ?int $gameId = null;

    private string $host;

    private ?string $guest = null;

    private RoomOptions $options;

    public function __construct(string $host, RoomOptions $options)
    {
        $this->host = $host;
        $this->options = $options;
    }

    public function getGameId(): ?int
    {
        return $this->gameId;
    }

    public function setGameId(?int $gameId): self
    {
        $this->gameId = $gameId;

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getGuest(): ?string
    {
        return $this->guest;
    }

    public function setGuest(?string $guest): self
    {
        $this->guest = $guest;

        return $this;
    }

    public function getOptions(): RoomOptions
    {
        return $this->options;
    }

    public function setOptions(RoomOptions $options): self
    {
        $this->options = $options;

        return $this;
    }
}
