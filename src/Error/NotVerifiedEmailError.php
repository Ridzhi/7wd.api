<?php

namespace App\Error;

class NotVerifiedEmailError extends Error
{
    public function __construct(string $email)
    {
        parent::__construct("email($email) not verified");
    }
}
