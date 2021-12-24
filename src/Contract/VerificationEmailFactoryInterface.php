<?php

namespace App\Contract;

use App\Domain\EmailVerification;
use Symfony\Component\Mime\Email;

interface VerificationEmailFactoryInterface
{
    public function factory(EmailVerification $emailVerification): Email;
}
