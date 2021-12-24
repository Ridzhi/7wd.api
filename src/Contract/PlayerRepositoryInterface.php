<?php

namespace App\Contract;

use App\Domain\Player;
use App\Error\NotFoundError;

interface PlayerRepositoryInterface
{
    /**
     * @throws NotFoundError
     */
    public function get(int $id): Player;
    public function findByEmail(string $email): ?Player;
    public function findByNickname(string $nickname): ?Player;
}
