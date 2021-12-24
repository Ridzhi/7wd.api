<?php

namespace App\Error;

class EmailAlreadyInUseError extends Base
{
    public function __construct(string $email)
    {
        parent::__construct("email($email) already in use");
    }
}
