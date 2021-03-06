<?php

namespace App\Error;

class MaxAttemptsRegistrationReachedError extends Error
{
    public function __construct(string $email)
    {
        parent::__construct(
            sprintf(
                'For email(%s) max attempts registration reached, try again later',
                $email,
            )
        );
    }
}
