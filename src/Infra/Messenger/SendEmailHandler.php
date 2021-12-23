<?php

namespace App\Infra\Messenger;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendEmailHandler implements MessageHandlerInterface
{
    public function __construct(
        private MailerInterface $mailer,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(SendEmailMessage $message): void
    {
        $this->mailer->send($message->getEmail());
    }
}
