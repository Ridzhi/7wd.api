<?php

namespace App\Handler;

use App\Contract\ConfirmationCodeFactoryInterface;
use App\Contract\EmailVerificationRepositoryInterface;
use App\Contract\PlayerRepositoryInterface;
use App\Contract\VerificationEmailFactoryInterface;
use App\Domain\EmailVerification;
use App\Error\EmailAlreadyInUseError;
use App\Error\MaxAttemptsRegistrationReachedError;
use App\Infra\Messenger\SendEmailMessage;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SendEmailVerificationHandler
{
    public function __construct(
        private PlayerRepositoryInterface $playerRepository,
        private EmailVerificationRepositoryInterface $emailVerificationRepository,
        private ConfirmationCodeFactoryInterface $codeFactory,
        private VerificationEmailFactoryInterface $emailFactory,
        private EntityManagerInterface $em,
        private MessageBusInterface $bus,
    )
    {
    }

    /**
     * @throws EmailAlreadyInUseError
     * @throws MaxAttemptsRegistrationReachedError
     */
    public function __invoke(string $email): EmailVerification
    {
        $player = $this->playerRepository->findByEmail($email);

        if ($player) {
            throw new EmailAlreadyInUseError($email);
        }

        $code = $this->codeFactory->factory(EmailVerification::CODE_SIZE);
        $expires = CarbonImmutable::now()->addSeconds(EmailVerification::CODE_TTL);

        $emailVerification = $this->emailVerificationRepository->findByEmail($email);

        if (!$emailVerification) {
            $emailVerification = (new EmailVerification())
                ->setEmail($email)
                ->setCode($code)
                ->setAttempts(1)
                ->setExpires($expires);
        } else {
            if ($blockedUntil = $emailVerification->getBlockedUntil()) {
                $blockIsActive = $blockedUntil->getTimestamp() > Carbon::now()->getTimestamp();

                if ($blockIsActive) {
                    throw new MaxAttemptsRegistrationReachedError($email);
                }

                // if expired, reset block
                $emailVerification->setBlockedUntil(null);
                $emailVerification->setAttempts(0);
            }

            $emailVerification
                ->setAttempts($emailVerification->getAttempts() + 1)
                ->setCode($code)
                ->setExpires($expires);

            if ($emailVerification->getAttempts() >= EmailVerification::MAX_ATTEMPTS) {
                $emailVerification->setBlockedUntil(
                    CarbonImmutable
                        ::now()
                        ->addSeconds(EmailVerification::BLOCK_PERIOD)
                );
            }
        }

        $this->em->persist($emailVerification);
        $this->em->flush();

        $this->bus->dispatch(new SendEmailMessage(
            $this->emailFactory->factory($emailVerification),
        ));

        return $emailVerification;
    }
}
