<?php

namespace App\Error;

class RoomError extends Error
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
