<?php

namespace App\Error;

class InvalidConfirmationCodeError extends Error
{
    public function __construct()
    {
        parent::__construct('invalid confirmation code');
    }
}
