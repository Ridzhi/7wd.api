<?php

namespace App\Error;

class ExpiredConfirmationCodeError extends Error
{
    public function __construct()
    {
        parent::__construct('expired confirmation code');
    }
}
