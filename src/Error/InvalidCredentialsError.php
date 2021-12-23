<?php

namespace App\Error;

class InvalidCredentialsError extends Base
{
    public function __construct()
    {
        parent::__construct('invalid credentials');
    }
}
