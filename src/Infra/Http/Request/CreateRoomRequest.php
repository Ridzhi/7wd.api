<?php

namespace App\Infra\Http\Request;

use App\Infra\Validator as Check;
use Symfony\Component\Validator\Constraints;

class CreateRoomRequest
{
    private ?bool $fast;

    #[
        Constraints\Positive,
        Constraints\LessThanOrEqual(value: 9999)
    ]
    private ?int $minRating;

    #[Check\Nickname]
    private ?string $enemy;

    public function __construct(array $params)
    {
        $this->fast = $params['fast'] ?? null;
        $this->minRating = $params['minRating'] ?? null;
        $this->enemy = $params['enemy'] ?? null;
    }

    /**
     * @return bool|null
     */
    public function getFast(): ?bool
    {
        return $this->fast;
    }

    /**
     * @return int|null
     */
    public function getMinRating(): ?int
    {
        return $this->minRating;
    }

    /**
     * @return string|null
     */
    public function getEnemy(): ?string
    {
        return $this->enemy;
    }
}
