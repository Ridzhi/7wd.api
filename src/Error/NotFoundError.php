<?php

namespace App\Error;

class NotFoundError extends Error
{
    public function __construct($key, string $subject)
    {
        parent::__construct("$subject($key) not found");
    }
}
