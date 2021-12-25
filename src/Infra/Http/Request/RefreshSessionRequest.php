<?php

namespace App\Infra\Http\Request;

use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\Validator\Constraints;

class RefreshSessionRequest
{
    #[
        Constraints\NotBlank(message: 'fingerprint is required'),
        Constraints\Uuid(message: 'invalid browser fingerprint', strict: false),
    ]
    private ?string $fingerprint;

    #[
        Constraints\NotBlank(message: 'refresh token is required'),
        Constraints\Uuid(message: 'refresh token invalid format'),
    ]
    private ?string $refreshToken;

    public function __construct(array $params, InputBag $cookies)
    {
        $this->fingerprint = $params['fingerprint'] ?? null;
        $this->refreshToken = $cookies->get('rt');
    }

    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}
