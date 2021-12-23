<?php

namespace App\Infra\Messenger;

use Symfony\Component\Mime\Email;

class SendEmailMessage
{
    public function __construct(
        private Email $email
    )
    {
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
