<?php

namespace App\Infra\Http\Request;

use App\Infra\Validator as Check;

class CheckEmailVerificationRequest
{
    #[Check\Email]
    private ?string $email;

    #[Check\ConfirmationCode]
    private ?string $code;

    public function __construct(array $params)
    {
        if (isset($params['email'])) {
            $this->email = strtolower($params['email']);
        }

        $this->code = $params['code'] ?? null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
