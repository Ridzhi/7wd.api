<?php

namespace App\Adapter;

use App\Contract\JwtDecoderInterface;
use App\Contract\JwtEncoderInterface;
use Firebase\JWT\JWT;

class JwtManager implements JwtEncoderInterface, JwtDecoderInterface
{
    private const ALG = 'HS256';

    public function __construct(
        private string $tokenSecret,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function decode(string $jwt): array
    {
        return (array) JWT::decode($jwt, $this->tokenSecret, [self::ALG]);
    }

    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->tokenSecret, self::ALG);
    }
}
