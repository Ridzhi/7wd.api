<?php

namespace App\Handler;

use App\Domain\EmailVerificationRepository;
use App\Domain\PlayerRepository;
use App\Error\Error;
use App\Error\EmailAlreadyInUseError;
use App\Error\ExpiredConfirmationCodeError;
use App\Error\InvalidConfirmationCodeError;
use App\Error\NotFoundError;
use Carbon\Carbon;

class CheckEmailVerificationHandler
{
    public function __construct(
        private PlayerRepository            $playerRepository,
        private EmailVerificationRepository $emailVerificationRepository,
    )
    {
    }

    /**
     * @param string $email
     * @param string $code
     * @return void
     * @throws EmailAlreadyInUseError
     * @throws ExpiredConfirmationCodeError
     * @throws InvalidConfirmationCodeError
     * @throws NotFoundError
     */
    public function __invoke(string $email, string $code)
    {
        if ($this->playerRepository->findByEmail($email)) {
            throw new EmailAlreadyInUseError($email);
        }

        $emailVerification = $this->emailVerificationRepository->findByEmail($email);

        if (!$emailVerification) {
            throw new NotFoundError($email, 'email verification');
        }

        if ($emailVerification->getCode() !== $code) {
            throw new InvalidConfirmationCodeError();
        }

        if ($emailVerification->getExpires()->getTimestamp() < Carbon::now()->getTimestamp()) {
            throw new ExpiredConfirmationCodeError();
        }
    }
}
