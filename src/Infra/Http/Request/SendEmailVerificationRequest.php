<?php

namespace App\Infra\Http\Request;

use App\Infra\Validator as Check;

class SendEmailVerificationRequest
{
    #[Check\Email]
    private ?string $email = null;

    public function __construct(array $params)
    {
        if (isset($params['email'])) {
            $this->email = strtolower($params['email']);
        }
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
