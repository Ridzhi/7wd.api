<?php

namespace App\Error;

class InvalidCredentialsError extends Error
{
    public function __construct()
    {
        parent::__construct('invalid credentials');
    }
}
