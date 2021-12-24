<?php

namespace App\Adapter;

use App\Contract\VerificationEmailFactoryInterface;
use App\Domain\EmailVerification;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class VerificationEmailFactory implements VerificationEmailFactoryInterface
{
    public function factory(EmailVerification $emailVerification): Email
    {
        return (new TemplatedEmail())
            ->to(new Address($emailVerification->getEmail(), $emailVerification->getEmail()))
            ->subject('7wd.online: email verification')
            ->htmlTemplate('emails/verification.html.twig')
            ->context([
                'expires' => $emailVerification->getExpires()->format(DATE_RFC850),
                'code' => $emailVerification->getCode()
            ]);
    }
}
