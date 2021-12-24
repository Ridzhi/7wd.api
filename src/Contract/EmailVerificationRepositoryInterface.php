<?php

namespace App\Contract;

use App\Domain\EmailVerification;

interface EmailVerificationRepositoryInterface
{
    public function findByEmail(string $email): ?EmailVerification;
}
