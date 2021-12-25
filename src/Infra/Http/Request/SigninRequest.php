<?php

namespace App\Infra\Http\Request;

use Symfony\Component\Validator\Constraints;

class SigninRequest
{
    #[Constraints\NotBlank(message: 'email is required')]
    private ?string $email;

    #[Constraints\NotBlank(message: 'password is required')]
    private ?string $password;

    #[
        Constraints\NotBlank(message: 'fingerprint is required'),
        Constraints\Uuid(message: 'invalid browser fingerprint', strict: false),
    ]
    private ?string $fingerprint;

    public function __construct(array $params)
    {
        if (isset($params['email'])) {
            $this->email = strtolower($params['email']);
        }

        $this->password = $params['password'] ?? null;
        $this->fingerprint = $params['fingerprint'] ?? null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }
}
