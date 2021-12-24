<?php

namespace App\Error;

class SecurityError extends Error
{
    public function __construct(string $message)
    {
        parent::__construct($message, loggable: true);
    }
}
